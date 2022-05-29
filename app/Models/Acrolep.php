<?php

namespace App\Models;

use App\Extended\Model;

class Acrolep extends Model
{
    protected $auditKeys = array(
        'roleid',
        'permid',
    );
    protected $fillable = array(
        'roleid',
        'permid',
    );
}
