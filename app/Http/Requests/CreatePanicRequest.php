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


    public function rules(): array
    {
        return [
            'longitude' => ['required', 'string'],
            'Latitude' => ['required', 'string'],
            'Panic_type' => ['string'],
            'reference_id' => ['required'],
            'user_name' => ['required', 'string'],
        ];
    }
}
