<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormAddon extends Component
{
    public function __construct(
        public string $id,
        public string $type,
        public string $variant = 'secondary',
        public string|null $text = null,
        public string|null $icon = null,
        public string|null $title = null,
    ) {}

    public function isButton(): bool
    {
        return 'button' === $this->type;
    }

    public function render()
    {
        return view('components.form-addon');
    }
}
