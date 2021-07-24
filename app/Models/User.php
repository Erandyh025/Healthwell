<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Jenssegers\Mongodb\Model;
class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes;
    use Notifiable;
    protected $primaryKey = '_id';
    const ADMIN = 1;
    const DOCTORS = 2;
    const PATIENTS = 3;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'uuid', 'name', 'email', 'password', 'validation', 'persons_id','roles_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function persons()
    {
        return $this->belongsTo(Persons::class);
    }
    public function roles()
    {
        return $this->belongsTo(Roles::class);
    }

}
