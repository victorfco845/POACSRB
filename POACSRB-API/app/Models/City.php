<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['city', 'region'];

    public function reports()
    {
        return $this->hasMany(Report::class, 'city_id');
    }

}
