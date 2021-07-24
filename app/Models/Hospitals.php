<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Hospitals extends Eloquent
{
    use SoftDeletes;
    protected $connection = "mongodb";
    protected $collection = 'hospitals';

    protected $fillable = [
        '_id', 'uuid', 'name', 'direction', 'photo',
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function doctors()
    {
        return $this->hasOne(Doctors::class);
    }
    public function patients()
    {
        return $this->hasOne(Patients::class);
    }
    public function recipe()
    {
        return $this->hasOne(Recipe::class);
    }

}
