<?php

namespace App\Actions;

use App\ValueObjects\Money;
use Illuminate\Database\Eloquent\Model;

class SyncHourlyRateAction
{
    public function execute(Model $model, array $validated): void
    {
        if (! empty($validated['hourly_rate']['amount'])) {
            $money = Money::fromDecimal(
                amount: (float) $validated['hourly_rate']['amount'],
                currency: $validated['hourly_rate']['currency'] ?? 'USD'
            );

            $model->hourlyRate = $money;
            $model->save();
        } elseif (array_key_exists('hourly_rate', $validated)) {
            $model->hourly_rate = null;
            $model->save();
        }
    }
}
