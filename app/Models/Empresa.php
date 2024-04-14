<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'alias',
        'logo',
        'telefono',
        'direccion',
        'correo',
        'director',
        'slogan',
        'video_institucional',
        'resumen',
        'facebook',
        'youtube',
        'twitter',
        'linkedin',
    ];
}
