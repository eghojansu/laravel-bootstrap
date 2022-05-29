<?php

namespace App\View\Components;

use App\Extensions\FormPropTrait;
use Illuminate\View\Component;

class FormInput extends Component
{
    use FormPropTrait;

    public function __construct(
        public string|null $name = null,
        public string|null $id = null,
        public string|null $label = null,
        public string|null $placeholder = null,
    ) {}

    public function render()
    {
        return view('components.form-input');
    }
}
