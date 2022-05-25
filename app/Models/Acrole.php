<?php

namespace App\Models;

use App\Extensions\BlameableTrait;
use App\Extensions\AuditableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acrole extends Model implements AuditableInterface
{
    use SoftDeletes, BlameableTrait;

    protected $table = 'acrole';
    protected $fillable = array(
        'roleid',
        'descrip',
    );
    protected $hidden = array();
    protected $casts = array();

    public function perms()
    {
        return $this->belongsToMany(
            Acperm::class,
            'acrolep',
            'roleid',
            'permid',
            'roleid',
            'permid',
        );
    }
}
