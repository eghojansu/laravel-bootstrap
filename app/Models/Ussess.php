<?php

namespace App\Models;

use App\Extensions\BlameableTrait;
use App\Extensions\AuditableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ussess extends Model implements AuditableInterface
{
    use SoftDeletes, BlameableTrait;

    protected $table = 'ussess';
    protected $fillable = array(
        'sessid',
        'ip',
        'agent',
        'payload',
        'active',
    );
    protected $hidden = array();
    protected $casts = array(
        'payload' => 'array',
    );
}
