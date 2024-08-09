<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    use HasFactory;

    protected $table = 'evidences';

    protected $fillable = [
        'evidence',
        'report_id',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public $timestamps = false; // Desactivar timestamps

}
