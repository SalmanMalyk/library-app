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

        // Shuffle the books collection to randomize the order
        $shuffledBooks = $books->shuffle();

        foreach ($authors as $author) {
            // Determine the number of books to assign (up to the remaining count)
            $numberOfBooksToAssign = rand(1, $shuffledBooks->count());

            // Take the specified number of books from the shuffled collection
            $booksToAssign = $shuffledBooks->take($numberOfBooksToAssign);

            // Attach the books to the author
            $author->books()->attach($booksToAssign->pluck('id'));

            // Remove the assigned books from the shuffled collection
            $shuffledBooks = $shuffledBooks->slice($numberOfBooksToAssign);
        }
    }

}
