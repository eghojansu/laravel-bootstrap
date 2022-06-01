<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormContent extends Component
{
    public function __construct(
        public string|null $text = null,
        public string|null $icon = null,
    ) {}

    public function render()
    {
        return view('components.form-content');
    }
}
