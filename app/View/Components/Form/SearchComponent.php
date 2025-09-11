<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

abstract class SearchComponent extends Component
{
    public function __construct(
        public ?string $searchId = null,
    ) {}
}
