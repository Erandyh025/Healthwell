<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class allowed_foods extends Eloquent
{
    use SoftDeletes;
    protected $connection = "mongodb";
    protected $collection = 'allowed_foods';

    protected $fillable = [
        '_id', 'uuid', 'name',
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function subsistence_allowance()
    {
        return $this->belongsTo(subsistence_allowance::class, '_id', 'subsistenceallowance_id');
    }
}
