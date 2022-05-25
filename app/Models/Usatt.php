<?php

namespace App\Models;

use App\Extensions\BlameableTrait;
use App\Extensions\AuditableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usatt extends Model implements AuditableInterface
{
    use SoftDeletes, BlameableTrait;

    protected $table = 'usatt';
    protected $fillable = array(
        'attid',
        'attleft',
        'attnext',
        'ip',
        'agent',
        'payload',
        'active',
    );
    protected $hidden = array();
    protected $casts = array(
        'payload' => 'array',
        'attnext' => 'datetime',
    );

    public function isLocked(): bool
    {
        return $this->attnext && $this->attnext > new \DateTime();
    }

    public function noAttemptLeft(): bool
    {
        return $this->attleft < 1;
    }
}
