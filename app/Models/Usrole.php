<?php

namespace App\Models;

use App\Extensions\BlameableTrait;
use App\Extensions\AuditableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usrole extends Model implements AuditableInterface
{
    use SoftDeletes, BlameableTrait;

    protected $table = 'usrole';
    protected $fillable = array(
        'roleid',
        'userid',
    );
    protected $hidden = array();
    protected $casts = array();
}
