<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'prem_type' => $this->prem_type,
            'accom_type' => $this->accom_type,
            'guest_count' => $this->guest_count,
            'price' => $this->price,
            'user_id' => $this->user_id,
            'materials' => $this->materials,
            'conveniences' => $this->conveniences,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
