<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Bracalets extends Eloquent
{
    use SoftDeletes;
    protected $connection = "mongodb";
    protected $collection = 'bracalets';

    protected $fillable = [
        '_id', 'blood_oxygenation', 'heart_rate',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    public function persons()
    {
        return $this->belongsTo(Persons::class, 'persons_id', '_id');
    }
}
