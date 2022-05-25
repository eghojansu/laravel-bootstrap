<?php

namespace App\Models;

use App\Extensions\AuditableInterface;
use App\Extensions\BlameableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acperm extends Model implements AuditableInterface
{
    use SoftDeletes, BlameableTrait;

    const PERM_ADM = 'adm';

    protected $table = 'acperm';
    protected $fillable = array(
        'permid',
        'descrip',
    );
    protected $hidden = array();
    protected $casts = array();

    public function roles()
    {
        return $this->belongsToMany(
            Acrole::class,
            'acrolep',
            'permid',
            'roleid',
            'permid',
            'roleid',
        );
    }
}
