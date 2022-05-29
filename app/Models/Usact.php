<?php

namespace App\Models;

use App\Extended\Model;

class Usact extends Model
{
    protected $auditable = false;
    protected $fillable = array(
        'activity',
        'ip',
        'agent',
        'payload',
        'active',
        'rectab',
        'recid',
    );
    protected $casts = array(
        'payload' => 'array',
        'recid' => 'array',
    );
}
