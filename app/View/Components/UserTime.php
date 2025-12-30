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

        $user = auth()->user();

        if (! $user) {
            $carbon = $this->time instanceof Carbon ? $this->time : Carbon::parse($this->time);

            return $carbon->format('g:i A'); // Fallback format
        }

        return $user->preferences->formatTime($this->time);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        {{ $formattedTime }}
        HTML;
    }
}
