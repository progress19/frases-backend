<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    protected $table = 'posts';
    protected $fillable = [
        'titulo',
        'subtitulo',
        'contenido',
        'fecha_publicacion',
        'tiempo_lectura',
        'estado'
    ];

    /**
     * Get the temas for the post.
     */
    public function temas()
    {
        return $this->belongsToMany(\App\Models\Tema::class, 'posts_pivot_temas', 'post_id', 'tema_id')
                    ->withPivot('created_at');
    }
}
