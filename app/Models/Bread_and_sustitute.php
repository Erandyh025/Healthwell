<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Bread_and_sustitute extends Eloquent
{
    use SoftDeletes;
    protected $connection = "mongodb";
    protected $collection = 'bread_and_sustitute';

    protected $fillable = [
        'uuid', 'name', 'count',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
