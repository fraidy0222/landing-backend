<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaNoticia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    public function noticias(): BelongsToMany
    {
        return $this->belongsToMany(Noticia::class, 'noticias_categoria')
        ->withTimestamps();
    }
}
