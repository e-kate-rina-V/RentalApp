<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReservationRequest extends FormRequest
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
            'arrival_date' => 'required|date',
            'depart_date' => 'required|date|after:arrival_date',
            'nights_num' => 'required|integer|min:1',
            'guestAdultCount' => 'required|integer|min:1',
            'guestChildrenCount' => 'nullable|integer|min:0',
            'guestBabyCount' => 'nullable|integer|min:0',
            'guestPets' => 'nullable|integer|min:0',
            'ad_id' => 'required|exists:ads,id',
            'total_cost' => 'required|numeric|min:0',
        ];
    }
}
