<?php

namespace App\View\Components;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserDate extends Component
{
    public string $formattedDate;

    public function __construct(
        public $date,
        public ?string $fallback = null
    ) {
        $this->formattedDate = $this->formatDate();
    }

    private function formatDate(): string
    {
        if (empty($this->date)) {
            return $this->fallback ?? '';
        }

        $carbon = $this->date instanceof Carbon ? $this->date : Carbon::parse($this->date);
        $userFormat = auth()->user()?->getPreferredDateFormat();

        if (! $userFormat) {
            return $carbon->format('M j, Y'); // Fallback format
        }

        return $carbon->format($userFormat->dateFormat());
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        {{ $formattedDate }}
        HTML;
    }
}
