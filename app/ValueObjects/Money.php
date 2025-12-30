<?php

namespace App\ValueObjects;

use App\Enums\Currency;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class Money implements Arrayable, JsonSerializable
{
    public function __construct(
        public readonly int $amount, // Amount in cents
        public readonly Currency $currency = Currency::USD
    ) {}

    public static function from(array $data): self
    {
        return new self(
            amount: (int) ($data['amount'] ?? 0),
            currency: isset($data['currency']) ? Currency::from($data['currency']) : Currency::USD
        );
    }

    public static function fromDecimal(float $amount, Currency|string $currency = Currency::USD): self
    {
        return new self(
            amount: (int) round($amount * 100),
            currency: is_string($currency) ? Currency::from($currency) : $currency
        );
    }

    public static function fromValidated(array $data): ?self
    {
        if (! isset($data['hourly_rate']['amount'])) {
            return null;
        }

        $hourly_rate = $data['hourly_rate'];

        return new self(
            amount: (int) round($hourly_rate['amount'] * 100),
            currency: is_string($hourly_rate['currency']) ? Currency::from($hourly_rate['currency']) : $hourly_rate['currency']
        );
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency->value,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function formatted(): string
    {
        $symbol = $this->currency->symbol();
        $decimalAmount = $this->amount / 100;

        return $symbol.number_format($decimalAmount, 2);
    }

    public function formattedForCsv(): string
    {
        $symbol = $this->currency->symbol();
        $decimalAmount = $this->amount / 100;

        return $symbol.number_format($decimalAmount, 2, '.', '');
    }

    public function toDecimal(): float
    {
        return $this->amount / 100;
    }

    public function toInputValue(): string
    {
        return number_format($this->toDecimal(), 2, '.', '');
    }

    public function equals(Money $other): bool
    {
        return $this->amount === $other->amount && $this->currency === $other->currency;
    }

    public function earnings(int $durationInSeconds): Money
    {
        $hours = $durationInSeconds / 3600;

        return new Money(
            amount: (int) round($this->amount * $hours),
            currency: $this->currency
        );
    }
}
