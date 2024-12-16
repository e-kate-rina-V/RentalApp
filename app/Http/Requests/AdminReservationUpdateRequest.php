<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminReservationUpdateRequest extends FormRequest
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
            'ad_id' => 'required|exists:ads,id',
            'user_email' => 'required|exists:users,email',
            'user_id' => 'required|exists:users,id',
            'arrival_date' => 'required|date',
            'depart_date' => 'required|date',
            'total_cost' => 'required|numeric|min:1',
        ];
    }
}
