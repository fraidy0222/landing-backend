<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'enlace',
        'categoria_enlace_id'
    ];

    public function categorias(): BelongsTo
    {
        return $this->belongsTo(CategoriaEnlace::class, 'categoria_enlace_id');
    }
}
