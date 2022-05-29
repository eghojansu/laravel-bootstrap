<?php

namespace App\Models;

use App\Extended\Model;

class Usrole extends Model
{
    protected $auditKeys = array('roleid', 'userid');
    protected $fillable = array(
        'roleid',
        'userid',
    );
}
