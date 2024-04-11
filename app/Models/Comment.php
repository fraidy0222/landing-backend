<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_comentario',
        'correo_comentario',
        'user_comentario',
        'comentario',
        'user_id',
        'noticia_id',
        'estado_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function noticia(): BelongsTo
    {
        return $this->belongsTo(Noticia::class);
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(EstadoNoticia::class);
    }
}
