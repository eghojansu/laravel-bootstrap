<?php

namespace App\Extended;

use App\Extensions\AuditableTrait;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class Model extends EloquentModel
{
    use SoftDeletes, AuditableTrait;

    const CREATED_AT = 'creat';
    const UPDATED_AT = 'updat';
    const DELETED_AT = 'delat';

    /** @var array|null */
    protected $auditKeys;

    public function getTable()
    {
        return $this->table ?? strtolower(cname(static::class));
    }

    public function getAuditKey(): string|null
    {
        return $this->auditKeys[0] ?? null;
    }

    public function getAuditKeys(): array
    {
        return $this->auditKeys ?? array();
    }

    public function getRouteKeyName()
    {
        return $this->getAuditKey() ?? parent::getRouteKeyName();
    }
}
