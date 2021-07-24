<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Schedule_appointment extends Eloquent
{
    use SoftDeletes;
    protected $connection = "mongodb";
    protected $collection = 'schedule_appointment';

    protected $fillable = [
        '_id', 'uuid', 'date', 'turn', 'patients_id',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    public function persons()
    {
        return $this->belongsTo(Persons::class, 'persons_id', '_id');
    }

}
