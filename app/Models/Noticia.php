<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Noticia extends Model
{
    use HasFactory;

    // public $timestamps = false;
    protected $fillable = [
        'titulo',
        'portada',
        'subtitulo',
        'descripcion',
        'user_id',
        'estado_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(CategoriaNoticia::class, 'noticias_categoria')
            ->withTimestamps();
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(EstadoNoticia::class, 'estado_id');
    }

    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
