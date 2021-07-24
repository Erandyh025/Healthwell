<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Domicile extends Eloquent
{
    use SoftDeletes;
    protected $connection = "mongodb";
    protected $collection = 'domicile';

    protected $fillable = [
        'uuid', 'type', 'street', 'number_ext', 'number_int', 'state', 'municipality', 'location', 'colony', 'postalCode', 'persons_id',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    public function persons()
    {
        return $this->belongsTo(Persons::class);
    }
}
