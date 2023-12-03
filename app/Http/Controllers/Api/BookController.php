<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Book\BookRepository;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(public BookRepository $bookRepository) {}

    public function index(Request $request)
    {
        $page = (int)$request->page ?? 1;
        $limit = 25;
        $books = $this->bookRepository->all(true, $page, $limit);
        $total = $this->bookRepository->all()->count();
        
        return response()->json([
            'books' => $books,
            'page'  => $page,
            'limit' => $limit,
            'pages' => round($total / $limit),
            'total' => $total
        ], 200);
    }
}
