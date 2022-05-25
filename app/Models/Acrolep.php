<?php

namespace App\Models;

use App\Extensions\BlameableTrait;
use App\Extensions\AuditableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acrolep extends Model implements AuditableInterface
{
    use SoftDeletes, BlameableTrait;

    protected $table = 'acrolep';
    protected $fillable = array(
        'roleid',
        'permid',
    );
    protected $hidden = array();
    protected $casts = array();
}
