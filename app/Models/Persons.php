<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Persons extends Eloquent
{
    use SoftDeletes;
    protected $connection = "mongodb";
    protected $collection = 'persons';

    protected $primaryKey = '_id';
    protected $fillable = [
        '_id', 'uuid', 'name', 'ap_patern', 'ap_matern', 'curp', 'cell_phone', 'telefone', 'photo',
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function users()
    {
        return $this->hasOne(User::class);
    }
    public function patients()
    {
        return $this->hasOne(Patients::class);
    }

    public function domicilie()
    {
        return $this->hasOne(Domicile::class);
    }
    public function doctors()
    {
        return $this->hasOne(Doctors::class);
    }
    public function schedule_appointment()
    {
        return $this->hasOne(Schedule_appointment::class);
    }

}
