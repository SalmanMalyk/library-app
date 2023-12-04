<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'book_id' => $this->id,
            'title' => $this->book_title,
            'description' => $this->book_description,
            'author' => [
                'id' => $this->author_id,
                'name' => $this->author_name
            ],
            'publisher' => [
                'id' => $this->publisher_id,
                'name' => $this->publisher_name
            ],
        ];
    }
}
