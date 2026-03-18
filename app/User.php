<?php

namespace App;

use App\Loan;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    use LaratrustUserTrait;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_online'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
    ];


    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
