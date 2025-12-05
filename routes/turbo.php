<?php

use App\Http\Controllers\Turbo\ClientSearchController;
use App\Http\Controllers\Turbo\ProjectSearchController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->as('turbo.')->group(function () {
    Route::get('clients-search', ClientSearchController::class)->name('clients-search.index');
    Route::get('projects-search', ProjectSearchController::class)->name('projects-search.index');
});
