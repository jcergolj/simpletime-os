<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class Duration implements Arrayable, JsonSerializable
{
    public function __construct(
        public readonly int $hours,
        public readonly int $minutes
    ) {}

    public static function fromSeconds(int $totalSeconds): self
    {
        $hours = (int) floor($totalSeconds / 3600);
        $minutes = (int) floor(($totalSeconds % 3600) / 60);

        return new self(
            hours: $hours,
            minutes: $minutes
        );
    }

    public static function from(array $data): self
    {
        return new self(
            hours: (int) ($data['hours'] ?? 0),
            minutes: (int) ($data['minutes'] ?? 0)
        );
    }

    public function toArray(): array
    {
        return [
            'hours' => $this->hours,
            'minutes' => $this->minutes,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function formatted(): string
    {
        if ($this->hours === 0 && $this->minutes === 0) {
            return '0h';
        }

        $parts = [];

        if ($this->hours > 0) {
            $parts[] = $this->hours.'h';
        }

        if ($this->minutes > 0) {
            $parts[] = $this->minutes.'m';
        }

        return implode(' ', $parts);
    }

    public function toSeconds(): int
    {
        return ($this->hours * 3600) + ($this->minutes * 60);
    }
}
