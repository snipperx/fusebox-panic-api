<?php

namespace App\Http\Validators;

use Illuminate\Support\Facades\Validator;

class UserValidator
{

    /**
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    public function validateLoginUser(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }
}
