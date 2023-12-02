<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookPublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publishers = User::where('user_type', UserType::Publisher)->get();
        $books = Book::all();

        foreach ($publishers as $publisher) {
            // For each publisher, select a random set of books
            $randomBooks = $books->random(rand(1, $books->count()));

            foreach ($randomBooks as $book) {
                // Check if the combination already exists
                if (!$publisher->publishedBooks()->where('book_id', $book->id)->exists()) {
                    // If it doesn't exist, attach the book to the publisher
                    $publisher->publishedBooks()->attach($book->id);
                }
            }
        }
    }
}
