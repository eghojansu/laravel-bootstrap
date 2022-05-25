<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Extensions\AuditableInterface;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements AuditableInterface
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userid',
        'name',
        'email',
        'password',
        'active',
        'joindt',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'joindt' => 'datetime',
    ];

    private $permissionsCache = array();

    public function publish(): array
    {
        return $this->only('name', 'email');
    }

    public function allowed(string ...$permissions): bool
    {
        if (array_intersect($this->permissionsCache, $permissions)) {
            return true;
        }

        array_push(
            $this->permissionsCache,
            ...$this->roles->reduce(
                static function (array $perms, Acrole $role) {
                    array_push(
                        $perms,
                        ...$role->perms->map(
                            static fn (Acperm $perm) => $perm->permid,
                        )->toArray(),
                    );

                    return $perms;
                },
                array(),
            ),
        );

        return !!array_intersect($this->permissionsCache, $permissions);
    }

    public function roles()
    {
        return $this->belongsToMany(
            Acrole::class,
            'usrole',
            'userid',
            'roleid',
            'userid',
            'roleid',
        );
    }

    public function attempts()
    {
        return $this->hasMany(Usatt::class, 'userid', 'userid');
    }
}
