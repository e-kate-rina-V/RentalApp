<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'adId' => 'required|integer|exists:ads,id',
            'ratings.cleanliness' => 'required|integer|min:0|max:5',
            'ratings.staffWork' => 'required|integer|min:0|max:5',
            'ratings.location' => 'required|integer|min:0|max:5',
            'ratings.valueForMoney' => 'required|integer|min:0|max:5',
            'reviews.positive' => 'nullable|string|max:500',
            'reviews.negative' => 'nullable|string|max:500',
            'reviews.comment' => 'nullable|string|max:1000',
            'averageRating' => 'required|numeric|min:0|max:5',
        ];
    }
}
