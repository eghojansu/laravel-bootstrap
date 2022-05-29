<?php

namespace App\Models;

use App\Extended\Model;

class Acrole extends Model
{
    protected $auditKeys = array('roleid');
    protected $fillable = array(
        'roleid',
        'descrip',
    );

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
