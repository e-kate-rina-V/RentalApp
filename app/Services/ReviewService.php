<?php

namespace App\Services;

use Illuminate\Http\Request;

class ReviewService
{
    public function prepareReviewData(Request $request, int $userId): array
    {
        return [
            'user_id' => $userId,
            'ad_id' => $request->input('adId'),
            'cleanliness' => $request->input('ratings.cleanliness'),
            'staff_work' => $request->input('ratings.staffWork'),
            'location' => $request->input('ratings.location'),
            'value_for_money' => $request->input('ratings.valueForMoney'),
            'positive' => $request->input('reviews.positive'),
            'negative' => $request->input('reviews.negative'),
            'comment' => $request->input('reviews.comment'),
            'average_rating' => $request->input('averageRating'),
        ];
    }
}
