<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientSearchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectFilterController;
use App\Http\Controllers\ProjectSearchController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportExportController;
use App\Http\Controllers\RunningTimerSessionController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\PreferencesController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TimeEntryController;
use App\Http\Controllers\TimerSessionCompletionController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('home');

Route::get('dashboard', DashboardController::class)
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Client routes
    Route::get('clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::patch('clients/{client}', [ClientController::class, 'update']);
    Route::delete('clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');

    // Project routes
    Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::patch('projects/{project}', [ProjectController::class, 'update']);
    Route::delete('projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // TimeEntry routes
    Route::get('time-entries', [TimeEntryController::class, 'index'])->name('time-entries.index');
    Route::get('time-entries/create', [TimeEntryController::class, 'create'])->name('time-entries.create');
    Route::post('time-entries', [TimeEntryController::class, 'store'])->name('time-entries.store');
    Route::get('time-entries/{timeEntry}/edit', [TimeEntryController::class, 'edit'])->name('time-entries.edit');
    Route::put('time-entries/{timeEntry}', [TimeEntryController::class, 'update'])->name('time-entries.update');
    Route::patch('time-entries/{timeEntry}', [TimeEntryController::class, 'update']);
    Route::delete('time-entries/{timeEntry}', [TimeEntryController::class, 'destroy'])->name('time-entries.destroy');

    // RunningTimerSession routes
    Route::get('running-timer-session/edit', [RunningTimerSessionController::class, 'edit'])->name('running-timer-session.edit');
    Route::post('running-timer-session', [RunningTimerSessionController::class, 'store'])->name('running-timer-session.store');
    Route::put('running-timer-session', [RunningTimerSessionController::class, 'update'])->name('running-timer-session.update');
    Route::delete('running-timer-session', [RunningTimerSessionController::class, 'destroy'])->name('running-timer-session.destroy');

    // Timer completion route
    Route::post('running-timer-session/completion', TimerSessionCompletionController::class)->name('running-timer-session.completion');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('report-exports', ReportExportController::class)->name('report-exports.show');

    Route::get('project-filter', ProjectFilterController::class)->name('project-filter');

    Route::get('clients-search', ClientSearchController::class)->name('clients-search.index');
    Route::get('projects-search', ProjectSearchController::class)->name('projects-search.index');

    Route::get('settings', SettingsController::class)
        ->name('settings');

    Route::prefix('settings')->as('settings.')->group(function () {
        Route::singleton('profile', ProfileController::class)->only(['edit', 'update']);
        Route::get('profile/delete', [ProfileController::class, 'delete'])->name('profile.delete');
        Route::post('profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::singleton('password', PasswordController::class)->only(['edit', 'update']);
        Route::singleton('preferences', PreferencesController::class)->only(['edit', 'update']);
    });
});
