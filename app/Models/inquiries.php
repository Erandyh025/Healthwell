<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class inquiries extends Eloquent
{
    use SoftDeletes;
    protected $connection = "mongodb";
    protected $collection = 'inquiries';
    protected $primaryKey = '_id';

    const TRATAMIENTO = true;

    protected $fillable = [
        'uuid', 'num_inquirie', 'tratamiento', 'patients_id', 'doctors_id',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function patients()
    {
        return $this->belongsTo(Patients::class);
    }
    public function doctors()
    {
        return $this->belongsTo(Doctors::class);
    }
    public function recipe()
    {
        return $this->hasOne(Recipe::class);
    }

}
