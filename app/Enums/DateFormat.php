<?php

namespace App\Enums;

enum DateFormat: string
{
    case US = 'us';
    case UK = 'uk';
    case EU = 'eu';

    public function dateFormat(): string
    {
        return match ($this) {
            self::US => 'm/d/Y',
            self::UK => 'd/m/Y',
            self::EU => 'd.m.Y',
        };
    }

    public function datetimeFormat(): string
    {
        return match ($this) {
            self::US => $this->dateFormat().' g:i A',
            self::UK => $this->dateFormat().' H:i',
            self::EU => $this->dateFormat().' H:i',
        };
    }

    public function datetimeFormatWithTime(TimeFormat $timeFormat): string
    {
        return $this->dateFormat().' '.$timeFormat->timeFormat();
    }

    public function inputFormat(): string
    {
        return match ($this) {
            self::US => 'Y-m-d',
            self::UK => 'Y-m-d',
            self::EU => 'Y-m-d',
        };
    }

    public function name(): string
    {
        return match ($this) {
            self::US => 'US (MM/DD/YYYY)',
            self::UK => 'UK (DD/MM/YYYY)',
            self::EU => 'EU (DD.MM.YYYY)',
        };
    }

    public function example(): string
    {
        $date = now()->setDate(2024, 12, 25);

        return $date->format($this->dateFormat());
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
        return self::US;
    }
}
