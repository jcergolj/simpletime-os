<?php

namespace App\ValueObjects;

use App\Enums\DateFormat;
use App\Enums\TimeFormat;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class DateTimeFormatter implements Arrayable, JsonSerializable
{
    public function __construct(
        public readonly DateFormat $dateFormat,
        public readonly TimeFormat $timeFormat
    ) {}

    public static function from(array $data): self
    {
        return new self(
            dateFormat: isset($data['date_format']) ? DateFormat::from($data['date_format']) : DateFormat::default(),
            timeFormat: isset($data['time_format']) ? TimeFormat::from($data['time_format']) : TimeFormat::default()
        );
    }

    public function toArray(): array
    {
        return [
            'date_format' => $this->dateFormat->value,
            'time_format' => $this->timeFormat->value,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function formatDate(Carbon|string $date): string
    {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        return $date->format($this->dateFormat->dateFormat());
    }

    public function formatTime(Carbon|string $time): string
    {
        if (is_string($time)) {
            $time = Carbon::parse($time);
        }

        return $time->format($this->timeFormat->timeFormat());
    }

    public function formatDatetime(Carbon|string $datetime): string
    {
        if (is_string($datetime)) {
            $datetime = Carbon::parse($datetime);
        }

        return $datetime->format($this->dateFormat->datetimeFormatWithTime($this->timeFormat));
    }
}
