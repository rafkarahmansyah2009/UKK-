<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['sometimes', 'string'],
            'username' => ['sometimes', 'string'],
            'email' => ['sometimes', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Get the login identifier provided by the user.
     */
    public function loginIdentifier(): string
    {
        return (string) ($this->input('login') ?? $this->input('username') ?? $this->input('email'));
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $identifier = $this->loginIdentifier();
        $password = (string) $this->input('password');
        $remember = $this->boolean('remember');

        // Check if identifier is an email, username, nis, or nip
        $field = 'username';
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } elseif (is_numeric($identifier)) {
            // Check if matches NIS or NIP
            if (User::where('nis', $identifier)->exists()) {
                $field = 'nis';
            } elseif (User::where('nip', $identifier)->exists()) {
                $field = 'nip';
            }
        }

        if (! Auth::attempt([$field => $identifier, 'password' => $password], $remember)) {
            // Also try email or username as fallback if field wasn't email
            $authenticated = false;
            if ($field !== 'email' && Auth::attempt(['email' => $identifier, 'password' => $password], $remember)) {
                $authenticated = true;
            } elseif ($field !== 'username' && Auth::attempt(['username' => $identifier, 'password' => $password], $remember)) {
                $authenticated = true;
            }

            if (! $authenticated) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'login' => trans('auth.failed'),
                    'username' => trans('auth.failed'),
                    'email' => trans('auth.failed'),
                ]);
            }
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->loginIdentifier()).'|'.$this->ip());
    }
}
