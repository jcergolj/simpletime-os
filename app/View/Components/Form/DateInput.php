<?php

namespace App\View\Components\Form;

use App\Enums\DateFormat;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DateInput extends Component
{
    public function __construct(
        public string $value = '',
        public bool $dataError = false
    ) {}

    public function inputClasses(): string
    {
        $classes = 'w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent text-base';

        if ($this->dataError) {
            $classes .= ' border-red-500';
        }

        return $classes;
    }

    public function userFormat(): ?DateFormat
    {
        return auth()->user()?->preferences->dateFormat;
    }

    public function formatExample(): string
    {
        $format = $this->userFormat();

        return $format instanceof DateFormat ? $format->example() : '';
    }

    public function render(): View|Closure|string
    {
        /** @var view-string $viewName */
        $viewName = 'components.form.date-input';

        return view($viewName);
    }
}
