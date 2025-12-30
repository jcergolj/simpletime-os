<?php

namespace App\Http\Controllers\Settings;

use App\Enums\DateFormat;
use App\Enums\TimeFormat;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdatePreferencesRequest;
use App\ValueObjects\Money;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Jcergolj\InAppNotifications\Facades\InAppNotification;

class PreferencesController extends Controller
{
    public function edit(Request $request): View
    {
        return view('settings.preferences.edit', [
            'dateFormat' => $request->user()->preferences->dateFormat,
            'timeFormat' => $request->user()->preferences->timeFormat,
            'dateFormatOptions' => DateFormat::options(),
            'timeFormatOptions' => TimeFormat::options(),
            'hourly_rate' => $request->user()->hourlyRate,
        ]);
    }

    public function update(UpdatePreferencesRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        $user->update([
            'date_format' => $validated['date_format'],
            'time_format' => $validated['time_format'],
            'hourly_rate' => Money::fromValidated($validated),
        ]);

        InAppNotification::success(__('Preferences updated.'));

        return to_route('settings.preferences.edit');
    }
}
