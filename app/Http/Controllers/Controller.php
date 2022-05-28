<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Service\Account;
use App\Service\Preference;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @property User|null $user
 * @property Preference $pref
 * @property Account $account
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $hive = array();

    public function __get($name)
    {
        if (isset($this->hive[$name]) || array_key_exists($name, $this->hive)) {
            return $this->hive[$name];
        }

        return $this->hive[$name] = match($name) {
            'user' => auth()->user(),
            'pref' => app(Preference::class),
            'account' => app(Account::class),
        };
    }
}
