<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Repositories\Book\BookRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(public BookRepository $bookRepository)
    {
    }

    public function index(Request $request)
    {
        if ($request->list_type == 'paginate') {
            $page = (int) $request->page ?? 1;
            $limit = 25;
            $books = $this->bookRepository->all(true, $page, $limit);
            $total = $this->bookRepository->all()->count();

            return response()->json(
                [
                    'books' => $books,
                    'page' => $page,
                    'limit' => $limit,
                    'pages' => ceil($total / $limit),
                    'total' => $total,
                ],
                200,
            );
        } else {
            $books = $this->bookRepository->all();
            $books = BookResource::collection($books);

            return response()->json(
                [
                    'data' => $books,
                    'message' => 'Books retrieved successfully',
                ],
                200,
            );
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:books,title',
            'description' => 'required|string',
            'author_id' => 'required|integer',
            'publisher_id' => 'required|integer',
        ]);

        $book = $this->bookRepository->create($request->all());

        return response()->json(
            [
                'data' => $book,
                'message' => 'Book created successfully',
            ],
            201,
        );
    }

    public function show($id)
    {
        $book = $this->bookRepository->find($id);

        if (!$book) {
            return response()->json(
                [
                    'message' => 'Book not found',
                ],
                404,
            );
        }

        return response()->json(
            [
                'data' => $book,
                'message' => 'Book retrieved successfully',
            ],
            200,
        );
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'title' => 'nullable|string|unique:books,title,' . $id,
            'description' => 'nullable|string',
            'author_id' => 'sometimes|integer|exists:users,id',
            'publisher_id' => 'sometimes|integer|exists:users,id',
        ]);
        $book = $this->bookRepository->find($id);

        if (!$book) {
            return response()->json(
                [
                    'message' => 'Book not found',
                ],
                404,
            );
        }

        $book = $this->bookRepository->update($request->all(), $id);

        return response()->json(
            [
                'data' => $book,
                'message' => 'Book updated successfully',
            ],
            200,
        );
    }

    public function destroy($id): JsonResponse
    {
        $book = $this->bookRepository->find($id);

        if (!$book) {
            return response()->json(
                [
                    'message' => 'Book not found',
                ],
                404,
            );
        }

        $this->bookRepository->delete($id);

        return response()->json(
            [
                'message' => 'Book deleted successfully',
            ],
            200,
        );
    }
}
