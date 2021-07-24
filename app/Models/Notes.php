<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Notes extends Model
{
    use SoftDeletes;
    protected $connection = "mongodb";
    protected $collection = 'notes';

    protected $fillable = [
        '_id', 'note',
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function persons()
    {
        return $this->belongsTo(Persons::class, 'persons_id', '_id');
    }
}
