<?php

namespace App\Service;

use App\Models\User;
use App\Service\Api;
use App\Models\Usatt;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class Account
{
    public function __construct(
        private Api $api,
        private Preference $preference,
    ) {}

    public function attempt(string $username, string $password, bool $remember = false)
    {
        $field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'userid';
        /** @var User */
        $user = User::where($field, $username)->first();

        if (!$user) {
            return $this->api->fail('account.invalid');
        }

        /** @var Usatt|null */
        $attempt = $user->attempts()->where(function (Builder $query) {
            $request = request();

            $query->where('ip', $request->ip());
            $query->where('agent', $request->userAgent());
        })->first();

        if ($attempt?->isLocked()) {
            return $this->api->fail(
                trans('account.locked') . '. ' .
                trans('account.attempt_next', array('at' => $attempt->attnext->format('D, d M Y H:i:s')))
            );
        }

        if ($attempt?->noAttemptLeft()) {
            return $this->api->fail(trans('attempt', array('left' => $attempt->attleft)));
        }

        if (!Hash::check($password, $user->getAuthPassword())) {
            // $this->
        }

        $credentials = array($attempt => $username, 'active' => 1) + compact('password');

        if (auth()->attempt($credentials, !!$remember)) {
            /** @var User */
            $user = auth()->user();

            return $this->data($user->publish());
        }
    }
}
