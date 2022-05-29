<?php

namespace App\Services;

use App\Models\Csmenu;
use App\States\Account;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class Menu
{
    public function __construct(private Account $account)
    {}

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
}
