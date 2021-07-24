<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Recipe extends Eloquent
{
    use SoftDeletes;
    protected $connection = "mongodb";
    protected $collection = 'recipe';

    protected $fillable = [
        'uuid', 'prescription', 'start_date', 'ending_date', 'inquiries_id',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    public function inquiries()
    {
        return $this->belongsTo(inquiries::class);
    }

}
