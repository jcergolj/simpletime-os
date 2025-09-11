<?php

namespace App\View\Components;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserTime extends Component
{
    public string $formattedTime;

    public function __construct(
        public $time,
        public ?string $fallback = null
    ) {
        $this->formattedTime = $this->formatTime();
    }

    private function formatTime(): string
    {
        if (empty($this->time)) {
            return $this->fallback ?? '';
        }

        $carbon = $this->time instanceof Carbon ? $this->time : Carbon::parse($this->time);
        $userFormat = auth()->user()?->getPreferredTimeFormat();

        if (! $userFormat) {
            return $carbon->format('g:i A'); // Fallback format
        }

        return $carbon->format($userFormat->timeFormat());
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        {{ $formattedTime }}
        HTML;
    }
}
