<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BooksResourece extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'book_title' => $this->book_title,
            'book_synopsis' => $this->book_synopsis,
            'order' => $this->order,
            'created_at' => $this->created_at,
        ];
    }
}
