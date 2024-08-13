<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'title', 'goal_id', 'comission_number', 'date', 'user_id',
        'total_people', 'total_women', 'total_men',
        'total_ethnicity', 'total_deshabilities',
        'city', 'region', 'inform', 'comment'
    ];

    public $timestamps = false;

    protected $casts = [
        'total_people' => 'integer',
        'total_women' => 'integer',
        'total_men' => 'integer',
        'total_ethnicity' => 'integer',
        'total_deshabilities' => 'integer',
        'user_id' => 'integer',
    ];

    public function goal()
    {
        return $this->belongsTo(Goal::class, 'goal_id');
    }

    // Puedes definir una relación con City si necesitas
    public function city()
    {
        return $this->belongsTo(City::class, 'city');
    }

    // Puedes definir una relación con Region si necesitas
    public function region()
    {
        return $this->belongsTo(Region::class, 'region');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
