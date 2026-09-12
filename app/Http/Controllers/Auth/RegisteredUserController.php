<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration selection view (Siswa vs Guru).
     */
    public function create(): View
    {
        return view('auth.register-select');
    }

    /**
     * Display the student registration form.
     */
    public function createSiswa(): View
    {
        return view('auth.register-siswa');
    }

    /**
     * Handle an incoming student registration request.
     */
    public function storeSiswa(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:'.User::class],
            'nis' => ['required', 'string', 'max:30', 'unique:'.User::class],
            'class' => ['required', 'string', 'max:50'],
            'major' => ['required', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'nis' => $request->nis,
            'class' => $request->class,
            'major' => $request->major,
            'phone' => $request->phone,
            'role' => 'member',
            'member_type' => 'siswa',
            'status' => 'active',
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        ActivityLog::record('member_registered', "Siswa baru mendaftar: {$user->name} ({$user->nis})", $user->id);

        return redirect(route('member.dashboard', absolute: false));
    }

    /**
     * Display the teacher registration form.
     */
    public function createGuru(): View
    {
        return view('auth.register-guru');
    }

    /**
     * Handle an incoming teacher registration request.
     */
    public function storeGuru(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:'.User::class],
            'nip' => ['required', 'string', 'max:30', 'unique:'.User::class],
            'subject' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'nip' => $request->nip,
            'subject' => $request->subject,
            'phone' => $request->phone,
            'role' => 'member',
            'member_type' => 'guru',
            'status' => 'active',
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        ActivityLog::record('member_registered', "Guru baru mendaftar: {$user->name} ({$user->nip})", $user->id);

        return redirect(route('member.dashboard', absolute: false));
    }
}
