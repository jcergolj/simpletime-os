<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreConfirmPasswordRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ConfirmPasswordController extends Controller
{
    public function create()
    {
        return view('auth.confirm-password');
    }

    public function store(StoreConfirmPasswordRequest $request)
    {
        throw_unless(Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->input('password'),
        ]), ValidationException::withMessages([
            'password' => __('auth.password'),
        ]));

        session(['auth.password_confirmed_at' => Carbon::now()->getTimestamp()]);

        return redirect()->intended(default: route('dashboard', absolute: false));
    }
}
