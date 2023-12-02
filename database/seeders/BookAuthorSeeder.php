<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = User::where('user_type', UserType::Author)->get();
        $books = Book::all();

        foreach ($authors as $author) {
            $randomBooks = $books->random(rand(1, $books->count()));

            foreach ($randomBooks as $book) {
                if (!$author->books()->where('book_id', $book->id)->exists()) {
                    $author->books()->attach($book->id);
                }
            }
        }
    }
}
