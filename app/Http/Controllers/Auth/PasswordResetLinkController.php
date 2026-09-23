<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string'],
        ], [
            'email.required' => 'Email, NIS, atau NIP wajib diisi.',
        ]);

        $identifier = $request->input('email');

        // Check if identifier is an email, NIS, or NIP
        $email = $identifier;
        if (is_numeric($identifier)) {
            // If it's numeric, try to find user by NIS or NIP
            $user = User::where('nis', $identifier)->orWhere('nip', $identifier)->first();
            if ($user) {
                $email = $user->email;
            } else {
                // If NIS/NIP not found, treat as invalid
                return back()->withInput($request->only('email'))
                    ->withErrors(['email' => 'NIS atau NIP tidak ditemukan dalam sistem kami.']);
            }
        } elseif (! filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            // If it's not email and not numeric, it's invalid
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Format email tidak valid.']);
        }

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(['email' => $email]);

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', 'Link reset password telah dikirim ke email Anda.')
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => 'Email tidak ditemukan dalam sistem kami.']);
    }
}
