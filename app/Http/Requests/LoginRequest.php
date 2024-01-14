<?php

namespace App\Http\Requests;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class LoginRequest extends FormRequest
{
    public const MAX_ATTEMPTS = 5;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }


    /**
     * @throws ValidationException
     */
    public function authenticateOrFail()
    {
        $this->ensureIsNotRateLimited();

        if (Auth::attempt($this->only('email', 'password')) === false) {
            RateLimiter::hit($this->throttleKey());


        }

        RateLimiter::clear($this->throttleKey());

    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     */
    public function ensureIsNotRateLimited()
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey(), self::MAX_ATTEMPTS) === false) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw new TooManyRequestsHttpException($seconds);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        /** @var string $email */
        $email = $this->input('email');

        return Str::lower("{$email}|{$this->ip()}");
    }


}

