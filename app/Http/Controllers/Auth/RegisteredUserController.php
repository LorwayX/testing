<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'student_number' => ['nullable', 'string', 'max:50'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $baseUsername = Str::slug($request->name, '');
        $username = $baseUsername ?: 'siswa';
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter++;
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'student_number' => $request->student_number ?? '12' . rand(10000, 99999),
            'class_name' => 'XI PPLG',
            'role' => 'student',
            'profile_visibility' => 'public',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
