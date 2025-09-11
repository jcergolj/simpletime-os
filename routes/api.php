<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::get('csrf-token', fn () => new JsonResponse([
        'token' => csrf_token(),
        'authenticated' => auth()->check(),
    ]))->name('api.csrf-token');
});
