<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreRegistrationRequest;
use App\Models\User;
use App\ValueObjects\Money;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function create()
    {
        // Check if any user already exists (only one user allowed in v1)
        if (! app()->environment('testing') && User::exists()) {
            abort(Response::HTTP_FORBIDDEN, __('Registration is closed. Only one user is allowed in v1.'));
        }

        return view('auth.register');
    }

    public function store(StoreRegistrationRequest $request)
    {
        // Check if any user already exists (only one user allowed in v1)
        if (! app()->environment('testing') && User::exists()) {
            abort(Response::HTTP_FORBIDDEN, __('Registration is closed. Only one user is allowed in v1.'));
        }

        $validated = $request->validated();

        event(new Registered(($user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'hourly_rate' => Money::fromValidated($validated),
        ]))));

        Auth::login($user);

        return redirect()->intended(default: route('dashboard', absolute: false));
    }
}
