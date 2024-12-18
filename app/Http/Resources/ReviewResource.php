<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'ad_id' => $this->ad_id,
            'user_id' => $this->user_id,
            'ratings' => [
                'cleanliness' => $this->cleanliness,
                'staff_work' => $this->staff_work,
                'location' => $this->location,
                'value_for_money' => $this->value_for_money,
            ],
            'reviews' => [
                'positive' => $this->positive,
                'negative' => $this->negative,
                'comment' => $this->comment,
            ],
            'average_rating' => $this->average_rating,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
