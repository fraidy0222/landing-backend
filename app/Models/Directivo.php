<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'prioridad',
        'cargo',
        'imagen',
        'biografia'
    ];
}
