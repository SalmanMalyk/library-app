<?php

namespace App\Repositories\Book;

use App\Models\Book;
use App\Interfaces\Book\BookRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

final class BookRepository implements BookRepositoryInterface
{
    public function __construct(public Book $model)
    {}
    
    public function all($paginate = null, $page = null, $limit = null)
    {
        $offset = ($page - 1) * $limit;
        // return Cache::remember("books-page-" . ($page ?? 0) . "-limit-" . ($limit ?? 0), 60, function() use ($limit, $offset, $paginate) {
            return $this->model::query()
                ->join('book_author', 'books.id', '=', 'book_author.book_id')
                ->join('book_publisher', 'books.id', '=', 'book_publisher.book_id')
                ->join('users', 'users.id', '=', 'book_publisher.publisher_id')
                ->join('users as authors', 'authors.id', '=', 'book_author.author_id')
                ->select(
                    'books.id', 
                    'users.id as publisher_id', 
                    'authors.id as author_id',
                    'books.title as book_title', 
                    'books.description as book_description', 
                    'users.name as publisher_name', 
                    'authors.name as author_name' 
                )
                ->orderBy('books.created_at', 'desc')
                ->when($paginate, function ($query) use ($limit, $offset) {
                    return $query->offset($offset)->limit($limit);
                })
                ->get();
        // });
    }

    public function find($id)
    {
        $book = $this->model::find($id);
        if ($book) {
            $book->load(['author:id,name,email', 'publisher:id,name,email']);
        }

        return $book;
    }

    public function create($data)
    {
        return DB::transaction(function () use ($data) {
            $book = $this->model::create($data);

            if (isset($data['author_id']) && !empty($data['author_id'])) {
                $book->author()->attach($data['author_id']);
            }

            if (isset($data['publisher_id']) && !empty($data['publisher_id'])) {
                $book->publisher()->attach($data['publisher_id']);
            }

            return $book;
        }, 3);
    }

    public function update($data, $id)
    {
        $book = $this->model::find($id);

        if (isset($data['author_id']) && !empty($data['author_id'])) {
            $book->author()->sync($data['author_id']);
        }

        if (isset($data['publisher_id']) && !empty($data['publisher_id'])) {
            $book->publisher()->sync($data['publisher_id']);
        }
        
        return $book->update($data);
    }

    public function delete($id)
    {
        $book = $this->model::find($id);
        return $book->delete();
    }
}
