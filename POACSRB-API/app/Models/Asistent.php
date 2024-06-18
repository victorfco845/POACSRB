<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistent extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'asistent',
        'companie_id',
        'petition_id',
        'job_id',
        'review_id',
        'search_id',
        'profile_id',
        'user_id',
        'created_at',
        'updated_at',
    ];
    public function companie()
    {
        return $this->belongsTo(Companie::class);
    }

    public function petition()
    {
        return $this->belongsTo(Petition::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    
}
