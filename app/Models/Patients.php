<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Patients extends Eloquent
{
    use SoftDeletes;
    protected $connection = "mongodb";
    protected $collection = 'patients';

    protected $fillable = [
        '_id', 'uuid', 'living_place', 'blood_type', 'disability', 'ethnic_group', 'religion', 'socioeconomic_level', 'age', 'hospitals_id', 'persons_id',
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    public function hospitals()
    {
        return $this->belongsTo(Hospitals::class);
    }
    public function persons()
    {
        return $this->belongsTo(Persons::class);
    }
    public function inquiries()
    {
        return $this->hasOne(inquiries::class);
    }
}
