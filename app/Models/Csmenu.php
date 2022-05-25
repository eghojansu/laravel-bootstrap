<?php

namespace App\Models;

use App\Extensions\BlameableTrait;
use App\Extensions\AuditableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Csmenu extends Model implements AuditableInterface
{
    use SoftDeletes, BlameableTrait;

    const SEPARATOR = '--sep';

    protected $table = 'csmenu';
    protected $fillable = array();
    protected $hidden = array();
    protected $casts = array(
        'attrs' => 'array',
        'args' => 'array',
    );

    public function getSeparatorAttribute(): bool
    {
        return self::SEPARATOR === $this->label;
    }
}
