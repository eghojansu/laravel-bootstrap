<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormContainer extends Component
{
    public function __construct(
        public string|null $method = 'POST',
        public string|null $autocomplete = 'off',
        public bool $grid = true,
        public bool $submit = true,
        public bool $validate = false,
        public int $gap = 3,
        public string $saveText = 'Save',
        public string $backText = 'Cancel',
        public string $back = 'dashboard',
    ) {}

    public function render()
    {
        return view('components.form-container');
    }
}
