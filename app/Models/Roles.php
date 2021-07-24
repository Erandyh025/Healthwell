<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Roles extends Eloquent
{
    use SoftDeletes;
    protected $connection = "mongodb";
    protected $collection = 'roles';

    protected $fillable = [
        '_id', 'uuid', 'name', 'description',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function users()
    {
        return $this->hasOne(User::class);
    }
}
