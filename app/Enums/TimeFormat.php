<?php

namespace App\Enums;

enum TimeFormat: string
{
    case Hour12 = '12';
    case Hour24 = '24';

    public function timeFormat(): string
    {
        return match ($this) {
            self::Hour12 => 'g:i A',
            self::Hour24 => 'H:i',
        };
    }

    public function datetimeFormat(DateFormat $dateFormat): string
    {
        return $dateFormat->dateFormat().' '.$this->timeFormat();
    }

    public function name(): string
    {
        return match ($this) {
            self::Hour12 => '12-hour (2:30 PM)',
            self::Hour24 => '24-hour (14:30)',
        };
    }

    public function example(): string
    {
        $time = now()->setTime(14, 30, 0);

        return $time->format($this->timeFormat());
    }

    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $format) {
            $options[(string) $format->value] = $format->name().' - '.$format->example();
        }

        return $options;
    }

    public static function default(): self
    {
        return self::Hour12;
    }
}
