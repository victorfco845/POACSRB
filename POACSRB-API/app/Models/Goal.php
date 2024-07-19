<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    // Definir la tabla asociada al modelo
    protected $table = 'goals';

    // Definir los campos que se pueden asignar en masa
    protected $fillable = [
        'goal',
    ];

    // Deshabilitar los timestamps si no los usas
    public $timestamps = false;

    // Definir las relaciones con otros modelos, si es necesario
    // En este caso, una meta puede tener muchos informes (Reports)
    public function reports()
    {
        return $this->hasMany(Report::class, 'goal_id');
    }
}
