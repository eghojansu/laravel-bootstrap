<?php

namespace App\Models;

use App\Extensions\BlameableTrait;
use App\Extensions\AuditableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cspref extends Model implements AuditableInterface
{
    use SoftDeletes, BlameableTrait;

    protected $table = 'cspref';
    protected $fillable = array(
        'name',
        'content',
    );
    protected $hidden = array();
    protected $casts = array(
        'content' => 'array',
    );
}
