<?php

namespace App\Http\Middleware;

use App\Service\Account;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Access
{
    public function __construct(private Account $account)
    {}

    public function handle(Request $request, \Closure $next, string ...$permissions)
    {
        if ($this->account->allowed(...$permissions)) {
            return $next($request);
        }

        abort(Response::HTTP_FORBIDDEN);
    }
}
