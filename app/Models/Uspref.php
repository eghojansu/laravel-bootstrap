<?php

namespace App\Models;

use App\Extended\Model;

class Uspref extends Model
{
    protected $auditKeys = array('name', 'userid');
    protected $fillable = array(
        'name',
        'content',
    );
    protected $casts = array(
        'content' => 'array',
    );
}
