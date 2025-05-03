<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    use HasFactory;
    
    protected $table = 'temas';
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];

    /**
     * Get the posts for the tema.
     */
    public function posts()
    {
        return $this->belongsToMany(\App\Models\Post::class, 'posts_pivot_temas', 'tema_id', 'post_id')
                    ->withPivot('created_at');
    }
}
