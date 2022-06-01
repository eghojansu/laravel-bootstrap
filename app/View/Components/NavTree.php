<?php

namespace App\View\Components;

use App\Services\Menu;
use Illuminate\View\Component;

class NavTree extends Component
{
    public function __construct(
        private Menu $menu,
        public string|null $group = null,
        public array|null $items = null,
    ) {}

    public function tree(): array
    {
        return $this->items ?? $this->menu->getTree($this->group)[$this->group] ?? array();
    }

    public function menuid(array $item): string
    {
        return 'tree-' . $item['menuid'];
    }

    public function clsa(array $item): string
    {
        $children = $item['items'] ?? null;
        $attrs = array(
            'href' => $item['url'] ?? '#',
            'aria-current' => $item['active'],
            'class' => array(
                $item['attrs']['class'] ?? null,
                'list-group-item list-group-item-action',
                $children ? 'd-flex' : null,
                $item['active'] ? 'active' : null,
            ),
        );

        if ($children) {
            $attrs['href'] = '#' . $this->menuid($item);
            $attrs['data-bs-toggle'] = 'collapse';
            $attrs['aria-expanded'] = 'false';
        }

        return clsr($attrs);
    }

    public function render()
    {
        return view('components.nav-tree');
    }
}
