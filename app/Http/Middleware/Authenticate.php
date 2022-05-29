<?php

namespace App\Http\Middleware;

use App\States\Account;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Factory;

class Authenticate extends Middleware
{
    public function __construct(
        Factory $auth,
        private Account $account,
    ) {
        parent::__construct($auth);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            $this->account->urlBackSave();

            return route('login');
        }
    }
}
