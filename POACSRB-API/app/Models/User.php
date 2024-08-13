<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'user',
        'email',
        'password',
        'user_number',
        'job',
        'status',
        'level',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public $timestamps = false;

}
