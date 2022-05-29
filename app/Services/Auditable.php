<?php

namespace App\Services;

use App\Models\User;
use App\Extended\Model;
use App\States\Account;
use Illuminate\Support\Str;

class Auditable
{
    private $uniques = array();

    public function __construct(private Account $account)
    {}

    public function creating(Model $model): void
    {
        $class = get_class($model);
        $unique = $this->uniques[$class] ?? (
            $this->uniques[$class] = $model->getConnection()->getSchemaBuilder()->hasColumn($model->getTable(), 'uniqid')
        );

        $model->setAttribute('creby', $this->getUserId());

        if ($unique) {
            $model->setAttribute('uniqid', Str::random(8));
        }

        $this->account->audit(Account::AUDIT_CREATE, $model);
    }

    public function updating(Model $model): void
    {
        $this->account->audit(Account::AUDIT_UPDATE, $model);
    }

    public function saving(Model $model): void
    {
        $model->setAttribute('updby', $this->getUserId());
    }

    public function restoring(Model $model): void
    {
        $model->setAttribute('delby', null);

        $this->account->audit(Account::AUDIT_RESTORE, $model);
    }

    public function deleted(Model $model): void
    {
        $model->setAttribute('delby', $this->getUserId());

        if (
            method_exists($model, 'useSoftDeletes')
            && method_exists($model, 'silentUpdate')
            && $model->useSoftDeletes()
            && $model->isDirty()
        ) {
            $model->silentUpdate();
        }

        $this->account->audit(Account::AUDIT_DELETE, $model);
    }

    private function getUserId(): string|null
    {
        $user = auth()->user();

        return $user instanceof User ? $user->getAttribute('userid') : null;
    }
}
