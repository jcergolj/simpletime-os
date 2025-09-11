<?php

namespace App\Casts;

use App\Enums\Currency;
use App\ValueObjects\Money;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class AsMoney implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Money
    {
        $amountKey = $key === 'rate' ? 'amount' : $key.'_amount';
        $currencyKey = $key === 'rate' ? 'currency' : $key.'_currency';

        if (isset($attributes[$amountKey]) && isset($attributes[$currencyKey])) {
            $currency = $attributes[$currencyKey];
            if (is_string($currency)) {
                $currency = Currency::from($currency);
            }

            return new Money(
                amount: (int) $attributes[$amountKey],
                currency: $currency
            );
        }

        if ($value === null) {
            return null;
        }

        $data = json_decode((string) $value, true);

        if (! is_array($data)) {
            return null;
        }

        return Money::from($data);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array|string|null
    {
        if ($value === null) {
            $amountKey = $key === 'rate' ? 'amount' : $key.'_amount';
            $currencyKey = $key === 'rate' ? 'currency' : $key.'_currency';

            if (array_key_exists($amountKey, $model->getAttributes()) || array_key_exists($currencyKey, $model->getAttributes())) {
                return [
                    $amountKey => null,
                    $currencyKey => null,
                ];
            }

            return null;
        }

        throw_unless($value instanceof Money, InvalidArgumentException::class, 'The given value is not a Money instance.');

        $amountKey = $key === 'rate' ? 'amount' : $key.'_amount';
        $currencyKey = $key === 'rate' ? 'currency' : $key.'_currency';

        $fillable = $model->getFillable();
        if (in_array($amountKey, $fillable) || in_array($currencyKey, $fillable)) {
            return [
                $amountKey => $value->amount,
                $currencyKey => $value->currency->value,
            ];
        }

        return json_encode($value->toArray());
    }
}
