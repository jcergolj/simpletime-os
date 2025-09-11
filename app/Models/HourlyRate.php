<?php

namespace App\Models;

use App\Enums\Currency;
use App\ValueObjects\Money;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property Money $rate
 */
class HourlyRate extends Model
{
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'amount' => 'integer',
            'rateable_id' => 'integer',
            'currency' => Currency::class,
        ];
    }

    protected function rate(): Attribute
    {
        return Attribute::make(
            get: fn () => new Money(
                amount: $this->amount,
                currency: $this->currency
            ),
            set: fn (Money $value) => [
                'amount' => $value->amount,
                'currency' => $value->currency->value,
            ]
        );
    }

    public function rateable(): MorphTo
    {
        return $this->morphTo();
    }

    public function toMoney(): Money
    {
        return $this->rate;
    }

    public function formatted(): string
    {
        return $this->rate->formatted();
    }

    public static function createFromDecimal(float $amount, Currency|string $currency, $rateable): self
    {
        $money = Money::fromDecimal($amount, $currency);

        return self::create([
            'rate' => $money,
            'rateable_id' => $rateable->id,
            'rateable_type' => $rateable::class,
        ]);
    }
}
