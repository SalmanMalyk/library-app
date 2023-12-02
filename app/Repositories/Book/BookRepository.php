<?php

namespace App\Repositories\Book;

use App\Models\Book;
use App\Interfaces\Book\BookRepositoryInterface;
use Illuminate\Support\Facades\Cache;

final class BookRepository implements BookRepositoryInterface
{
    public function __construct(public Book $model)
    {}
    
    public function all($paginate = null, $page = null, $limit = null)
    {
        if ($paginate) {
            $offset = ($page - 1) * $limit;
            return Cache::remember("books-page-{$page}-limit-{$limit}", 60, function () use ($limit, $offset) {
                return $this->model::query()
                    ->join('book_author', 'books.id', '=', 'book_author.book_id')
                    ->join('book_publisher', 'books.id', '=', 'book_publisher.book_id')
                    ->join('users', 'users.id', '=', 'book_publisher.publisher_id')
                    ->join('users as authors', 'authors.id', '=', 'book_author.author_id')
                    ->select('books.id', 'books.title as book_title', 'users.name as publisher_name', 'authors.name as author_name')
                    ->orderBy('books.created_at', 'desc')
                    ->skip($offset)
                    ->take($limit)
                    ->get();
            });
        }

        return $this->model::all();
    }

    public function find($id)
    {
        return $this->model::find($id);
    }

    public function create($data)
    {
        return $this->model::create($data);
    }

    public function update($data, $id)
    {
        $book = $this->model::find($id);
        return $book->update($data);
    }

    public function delete($id)
    {
        $book = $this->model::find($id);
        return $book->delete();
    }
}
