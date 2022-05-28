<?php

namespace App\Service;

use App\Models\User;
use App\Models\Usact;
use App\Models\Acperm;
use App\Models\Acrole;
use App\Service\Api;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Account
{
    private $cache = array();

    public function __construct(
        private Api $api,
        private Preference $preference,
    ) {}

    public function allowed(string ...$permissions): bool
    {
        /** @var User|null */
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        $cache = &$this->cache[$user->userid];

        if (!$cache) {
            $cache = array();
        }

        if (!$permissions || array_intersect($cache, $permissions)) {
            return true;
        }

        array_push(
            $cache,
            ...$user->roles->reduce(
                static function (array $perms, Acrole $role) {
                    array_push(
                        $perms,
                        ...$role->perms->map(
                            static fn (Acperm $perm) => $perm->permid,
                        )->toArray(),
                    );

                    return $perms;
                },
                array(),
            ),
        );

        return !!array_intersect($cache, $permissions);
    }

    public function record(
        string $activity,
        array $payload = null,
        bool $active = false,
    ): Usact {
        /** @var User */
        $user = Auth::user();
        $request = request();
        $activity = new Usact(array(
            'activity' => $activity,
            'payload' => $payload,
            'ip' => $request->ip(),
            'agent' => $request->userAgent(),
            'active' => $active,
        ));

        if ($user) {
            $user->activities()->save($activity);
        } else {
            $activity->save();
        }

        return $activity;
    }

    public function attempt(
        string $username,
        string $password,
        bool $remember = null,
    ): array {
        $field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'userid';

        /** @var User */
        $user = User::where($field, $username)->first();

        if (!$user) {
            return $this->api->fail('account.invalid');
        }

        $request = request();
        $attempt = $user->getActiveAttempt($request->ip(), $request->userAgent());

        if ($attempt?->isLocked()) {
            return $this->api->fail(
                sprintf(
                    '%s (%s)',
                    trans('account.locked'),
                    trans('account.attempt_next', array('at' => $attempt->attnext->format('D, d M Y H:i:s'))),
                ),
            );
        }

        if (!Hash::check($password, $user->getAuthPassword())) {
            if (!$attempt) {
                $attempt = $user->newAttempt(
                    $this->preference->attMax,
                    $request->ip(),
                    $request->userAgent(),
                );
            }

            $attempt->increase($this->preference->attMax, $this->preference->attTo);

            return $this->api->fail(
                sprintf(
                    '%s (%s)',
                    trans('account.invalid'),
                    trans('account.attempt', array('left' => $attempt->attleft)),
                ),
            );
        }

        $attempt?->deactivate();

        if (!$user->active) {
            return $this->api->fail('account.inactive');
        }

        Auth::login($user, $remember);
        $this->record('login');

        return $this->api->ok('account.welcome', $user->publish());
    }

    public function logout()
    {
        $this->record('logout');

        auth('web')->logout();

        return $this->api->ok('account.out');
    }
}
