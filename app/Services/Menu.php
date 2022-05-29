<?php

namespace App\Services;

use App\Models\Csmenu;
use App\States\Account;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Route;

class Menu
{
    private $activeRoute;

    public function __construct(private Account $account)
    {
        $this->activeRoute = request()->route()->getName();
    }

    public function getActiveRoute(): string|null
    {
        return $this->activeRoute;
    }

    public function setActiveRoute(string|null $route): static
    {
        $this->activeRoute = $route;

        return $this;
    }

    public function isRouteMatch(string|null $route): bool
    {
        return $this->activeRoute === $route;
    }

    public function getMenu(string $group, Csmenu $parent = null): Collection
    {
        return Csmenu::where(function (Builder $builder) use ($group, $parent) {
            if ($parent) {
                $builder->where('parent', $parent->menuid);
            } else {
                $builder->whereNull('parent');
            }

            $builder->where('grp', $group);
        })->orderBy('grade')->get();
    }

    public function getTree(string ...$groups): array
    {
        $rows = Csmenu::whereIn('grp', $groups)->get();
        $pick = array(
            'menuid',
            'label',
            'icon',
            'parent',
            'grp',
            'attrs',
        );

        /** @var array */
        $menu = $rows->filter(
            static fn (Csmenu $row) => !$row->parent && (
                !$row->perm || $this->account->allowed($row->perm)
            ),
        )->sortBy('grade')->reduce(
            function (array $menu, Csmenu $row) use ($rows, $pick) {
                /** @var Collection */
                $children = $rows->filter(
                    fn (Csmenu $child) => (
                        $child->grp === $row->grp
                        && $child->parent === $row->menuid
                        && (
                            !$child->perm
                            || $this->account->allowed($child->perm)
                        )
                    ),
                );
                $props = $this->menuProps($row);

                if ($props['url'] || $children->isNotEmpty()) {
                    $add = $row->only($pick) + $props;
                    $add['items'] = $children->sortBy('grade')->map(
                        fn (Csmenu $row) => $row->only($pick) + $this->menuProps($row),
                    )->values()->toArray();
                    $add['active'] = $add['active'] || array_reduce(
                        $add['items'],
                        static fn (bool|null $active, array $row) => $active || $row['active'],
                    );

                    $menu[$row->grp][] = $add;
                }

                return $menu;
            },
            array(),
        );

        return $menu;
    }

    private function menuProps(Csmenu $menu): array
    {
        $url = $menu->url && '#' !== $menu->url ? $menu->url : (
            Route::has($menu->route ?? '#') ? route($menu->route, $menu->args ?? array()) : null
        );
        $active = $this->isRouteMatch($menu->route);

        return compact('url', 'active');
    }
}
