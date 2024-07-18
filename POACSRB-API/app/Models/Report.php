<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'title', 'comission_number', 'date', 'user_id',
        'total_people', 'total_women', 'total_men',
        'total_ethnicity', 'total_deshabilities',
        'city', 'region', 'inform', 'comment'
    ];
        public $timestamps = false;

}
