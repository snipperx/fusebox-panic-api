<?php

namespace App\Http\Requests;

use App\Models\PanicZ;
use Illuminate\Foundation\Http\FormRequest;

class CreatePanicRequest extends FormRequest
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
            'longitude' => ['required', 'string'],
            'Latitude' => ['required', 'string'],
            'panic_type' => ['string'],
            'reference_id' => ['required', 'integer'],
            'user_name' => ['required', 'string'],
        ];
    }
}
