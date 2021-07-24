<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Subsistence_allowance extends Eloquent
{
    use SoftDeletes;
    protected $connection = "mongodb";
    protected $collection = 'subsistence_allowance';

    protected $fillable = [
        '_id', 'allowed_foods', 'forbidden_foods', 'bread_and_sustitute', 'patients_id', 'observer',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
