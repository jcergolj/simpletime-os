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

        $user = auth()->user();

        if (! $user) {
            $carbon = $this->date instanceof Carbon ? $this->date : Carbon::parse($this->date);

            return $carbon->format('M j, Y'); // Fallback format
        }

        return $user->preferences->formatDate($this->date);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
        {{ $formattedDate }}
        HTML;
    }
}
