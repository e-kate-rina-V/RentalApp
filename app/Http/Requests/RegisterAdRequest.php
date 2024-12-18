<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAdRequest extends FormRequest
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
            'title' => "required|string|max:255",
            'description' => "required|string|max:65535",
            'prem_type' => 'required|in:house,flat,hotel_room',
            'accom_type' => 'required|in:entire_place,private_room,shared_room',
            'guest_count' => 'required|integer|min:1',
            'price' => 'required|numeric|min:1',
            'conven' => 'array',
            'conven.*' => 'string|max:255',
            'materials' => 'array',
            'materials.*' => 'file|mimes:jpeg,png,jpg,avif,webp,mp4,mov|max:2048',
        ];
    }
}
