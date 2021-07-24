<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Blood_pressure extends Eloquent
{
    use SoftDeletes;
    protected $connection = "mongodb";
    protected $collection = 'blood_pressure';

    protected $fillable = [
        '_id', 'morning', 'night'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    public function persons()
    {
        return $this->belongsTo(Persons::class, 'persons_id', '_id');
    }
}
