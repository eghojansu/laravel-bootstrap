<?php

namespace App\Extensions;

use Illuminate\Support\Str;

trait FormPropTrait
{
    public function id(): string
    {
        return $this->id ?? 'input-' . Str::kebab($this->name);
    }

    public function label(): string
    {
        return $this->label ?? Str::title($this->name);
    }

    public function hint(): string|false
    {
        return $this->placeholder ?? $this->label();
    }
}
