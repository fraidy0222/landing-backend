<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EstadoNoticia extends Model
{
    use HasFactory;

    protected $table = 'estados';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    public function noticia(): HasOne
    {
        return $this->hasOne(Noticia::class);
    }

    public function commet(): HasOne
    {
        return $this->hasOne(Comment::class);
    }
}
