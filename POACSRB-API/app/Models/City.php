<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['city', 'region_id'];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
