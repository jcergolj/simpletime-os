<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::get('csrf-token', fn () => new \Illuminate\Http\JsonResponse([
        'token' => csrf_token(),
        'authenticated' => auth()->check(),
    ]))->name('api.csrf-token');
});
