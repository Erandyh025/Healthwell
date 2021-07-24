<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Doctors extends Eloquent
{
    use SoftDeletes;
    protected $connection = "mongodb";
    protected $collection = 'doctors';

    protected $fillable = [
        'uuid', 'id_card', 'specialty', 'sub_especialty', 'consulting_room', 'hospitals_id', 'persons_id'
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
