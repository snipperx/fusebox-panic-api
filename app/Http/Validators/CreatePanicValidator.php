<?php

namespace App\Http\Validators;


use Illuminate\Support\Facades\Validator;
class CreatePanicValidator
{
    /**
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    public function validatePanicAlert(array $data)
    {
        return Validator::make($data, [
            'longitude' => ['required', 'string'],
            'latitude' => ['required', 'string'],
            'user_name' => ['required', 'string'],
            'Panic_type' => ['required', 'string'],
        ]);
    }
}
