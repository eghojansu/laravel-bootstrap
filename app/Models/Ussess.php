<?php

namespace App\Models;

use App\Extended\Model;

class Ussess extends Model
{
    protected $auditKeys = array('sessid');
    protected $fillable = array(
        'sessid',
        'ip',
        'agent',
        'payload',
        'active',
    );
    protected $casts = array(
        'payload' => 'array',
    );
}
