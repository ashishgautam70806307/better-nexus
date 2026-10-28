<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required','string','email','max:255',
            ],
            'remember' => ['nullable', 'boolean'],
            'password' => [
                'required','string', 'max:1024',
            ],
        ];
    }

    public function authenticate(): void
    {
        $email = Str::lower(
            trim((string) $this->input('email'))
        );

        $key = $email.'|'.$this->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'email' => "Please try again after {$seconds} seconds.",
            ]);
        }

        $authenticated = Auth::guard('web')->attempt([
            'email' => $email,
            'password' => $this->input('password'),
            'is_admin' => true,
        ], $this->boolean('remember'));

        if (! $authenticated) {
            RateLimiter::hit($key, 60);

            throw ValidationException::withMessages([
                'email' => 'These credentials do not match an admin account.',
            ]);
        }

        RateLimiter::clear($key);
    }
}