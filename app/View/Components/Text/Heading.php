<?php

namespace App\View\Components\Text;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Heading extends Component
{
    public function __construct(
        public string $size = 'lg'
    ) {}

    public function sizeClasses(): string
    {
        return match ($this->size) {
            'lg' => 'text-lg',
            'xl' => 'text-xl',
            '2xl' => 'text-2xl',
            default => $this->size,
        };
    }

    public function render(): View|Closure|string
    {
        return view('components.text.heading');
    }
}
