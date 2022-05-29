<?php

namespace App\States;

use App\Models\User;
use App\Models\Usact;
use App\Services\Api;
use App\Models\Acperm;
use App\Models\Acrole;
use App\Extended\Model;
use App\Services\Preference;
use Illuminate\Support\Facades\Hash;

class Account
{
    const AUDIT_CREATE = 'create';
    const AUDIT_UPDATE = 'update';
    const AUDIT_DELETE = 'delete';
    const AUDIT_RESTORE = 'restore';

    const URL_BACK = 'back_url';

    private $permissions = array();

    public function __construct(
        private Preference $preference,
        private Api $api,
    ) {}

    public function urlBackSave(): static
    {
        session(array(
            self::URL_BACK => request()->fullUrl(),
        ));

        return $this;
    }

    public function urlBackGet(): string|null
    {
        $session = session();
        $backUrl = $session->get(self::URL_BACK);

        $session->remove(self::URL_BACK);

        return $backUrl;
    }

    public function user(): User|null
    {
        /** @var User|null */
        $user = auth()->user();

        return $user;
    }

    public function allowed(string ...$permissions): bool
    {
        if (!$user = $this->user()) {
            return false;
        }

        if (!$permissions || array_intersect($this->permissions, $permissions)) {
            return true;
        }

        array_push(
            $this->permissions,
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

        return !!array_intersect($this->permissions, $permissions);
    }

    public function record(
        string $activity,
        array $payload = null,
        bool $active = false,
    ): Usact {
        $request = request();
        $activity = new Usact(array(
            'activity' => $activity,
            'payload' => $payload,
            'ip' => $request->ip(),
            'agent' => $request->userAgent(),
            'active' => $active,
        ));

        $this->saveActivity($activity);

        return $activity;
    }

    public function audit(
        string $activity,
        Model $model,
    ): Usact|null {
        if (!$model->auditable()) {
            return null;
        }

        $request = request();
        $recid = array_map(
            static fn (string $name) => $model->getAttribute($name),
            array_combine(
                $model->getAuditKeys(),
                $model->getAuditKeys(),
            ),
        );
        $payload = match($activity) {
            self::AUDIT_UPDATE => $model->getChanges(),
            default => null,
        };

        $activity = new Usact(array(
            'activity' => $activity,
            'payload' => $payload,
            'ip' => $request->ip(),
            'agent' => $request->userAgent(),
            'recid' => $recid,
            'rectab' => $model->getTable(),
        ));

        $this->saveActivity($activity);

        return $activity;
    }

    public function saveActivity(Usact $activity): bool
    {
        if ($user = $this->user()) {
            return !!$user->activities()->save($activity);
        }

        return $activity->save();
    }

    public function attempt(
        string $account,
        string $password,
        bool $remember = null,
    ): array {
        $field = filter_var($account, FILTER_VALIDATE_EMAIL) ? 'email' : 'userid';

        /** @var User */
        $user = User::where($field, $account)->first();

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

        auth()->login($user, $remember);
        $this->record('login');

        return $this->api->ok('account.welcome', $user->publish() + array(
            'redirect' => $this->urlBackGet(),
        ));
    }

    public function logout()
    {
        $this->record('logout');

        auth('web')->logout();

        return $this->api->ok('account.out');
    }
}
