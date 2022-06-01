<?php

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class FormControl extends Component
{
    const LAYOUT_GRID = 'grid';

    const TYPE_CHECK = 'checkbox';
    const TYPE_PASS = 'password';

    public function __construct(
        public string $name = 'name',
        public string $type = 'text',
        public string $layout = 'grid',
        public string|null $value = null,
        public string|null $id = null,
        public string|null $label = null,
        public string|null $placeholder = null,
        public string|null $hint = null,
        public bool $checked = false,
        public bool $plain = false,
        public bool $readonly = false,
        public bool $generator = false,
        public bool $view = true,
        public bool $break = false,
        public bool $float = false,
        public int $width = 4,
        public int $mb = 0,
        public string $breakpoint = 'md',
        public array|null $addonsStart = null,
        public array|null $addonsEnd = null,
    ) {}

    public function id(): string
    {
        return $this->id ?? 'input-' . Str::kebab($this->name);
    }

    public function label(): string
    {
        return $this->label ?? str_replace('_', ' ', Str::title($this->name));
    }

    public function placeholder(): string|false
    {
        return $this->placeholder ?? $this->label();
    }

    public function idHelp(): string
    {
        return $this->id() . '-help';
    }

    public function value(): string|null
    {
        return match($this->type) {
            self::TYPE_CHECK => $this->value ?? 'on',
            self::TYPE_PASS => null,
            default => old($this->name, $this->value),
        };
    }

    public function checked(): bool
    {
        return match($this->type) {
            self::TYPE_CHECK => $this->value() === old($this->name),
            default => false,
        };
    }

    public function addonsStart(): array
    {
        $addons = match($this->type) {
            default => array(),
        };

        if ($this->addonsStart) {
            $addons = array_merge($addons, $this->addonsStart);
        }

        return $addons;
    }

    public function addonsEnd(): array
    {
        $addons = match($this->type) {
            'password' => $this->addonsPassword(),
            default => array(),
        };

        if ($this->addonsEnd) {
            $addons = array_merge($addons, $this->addonsEnd);
        }

        return $addons;
    }

    public function isEmpty(): bool
    {
        return null === old($this->name, $this->value);
    }

    public function isGrid(): bool
    {
        return self::LAYOUT_GRID === $this->layout;
    }

    public function isCol(): bool
    {
        return $this->width > -1;
    }

    public function isCheck(): bool
    {
        return self::TYPE_CHECK === $this->type;
    }

    public function isControl(): bool
    {
        return self::TYPE_CHECK !== $this->type;
    }

    public function isGroup(): bool
    {
        return $this->addonsStart() || $this->addonsEnd();
    }

    public function render()
    {
        return view('components.form-control');
    }

    private function addonsPassword(): array
    {
        $addons = array();

        if ($this->view) {
            $addons['toggle-password'] = array(
                'icon' => 'eye',
                'title' => trans('form.toggle_password'),
                'type' => 'button',
            );
        }

        if ($this->generator) {
            $addons['create-password'] = array(
                'icon' => 'key',
                'title' => trans('form.create_password'),
                'type' => 'button',
            );
        }

        return $addons;
    }
}
