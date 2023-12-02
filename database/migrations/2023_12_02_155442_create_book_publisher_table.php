<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_publisher', function (Blueprint $table) {
            $table->id();

            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('publisher_id')->constrained('users')->onDelete('cascade');

            $table->unique(['book_id', 'publisher_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_publisher_tale');
    }
};
