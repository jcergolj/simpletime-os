<?php

namespace App\Actions;

use App\ValueObjects\Money;
use Illuminate\Database\Eloquent\Model;

class SyncHourlyRateAction
{
    public function execute(Model $model, array $validated): void
    {
        if (! empty($validated['hourly_rate_amount'])) {
            $money = Money::fromDecimal(
                amount: (float) $validated['hourly_rate_amount'],
                currency: $validated['hourly_rate_currency'] ?? 'USD'
            );

            if ($model->wasRecentlyCreated || ! $model->exists) {
                $model->hourlyRate()->create([
                    'rate' => $money,
                ]);
            } else {
                $model->hourlyRate()->updateOrCreate(
                    ['rateable_id' => $model->id, 'rateable_type' => $model::class],
                    ['rate' => $money]
                );
            }
        } elseif (array_key_exists('hourly_rate_amount', $validated)) {
            $model->hourlyRate()->delete();
        }
    }
}
