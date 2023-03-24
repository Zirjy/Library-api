<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailReviewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return[
            'id' => $this->id,
            'book_title '=> $this->book_title,
            'order '=> $this->order,
            'human' => $this->whenLoaded('human'),
            'fans_review'=> $this->fans_review,
            'book_title '=> $this->book_title,
            'reviews' => $this->whenLoaded('reviews', function(){
                return collect($this->reviews)->each(function($review){
                    $review->reviewer;
                    return $review;
                });
            }),
            'created_at' => $this->created_at
        ];
    }
}
