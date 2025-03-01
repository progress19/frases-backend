<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frase extends Model
{
    protected $table = 'frases';
    public $timestamps = false;  // Si no tienes columnas de timestamps

    public function tipos()
    {
        return $this->belongsToMany(\App\Tipo::class, 'frases_pivot_tipos', 'frase_id', 'tipo_id')->withPivot('created_at');
    }
    

}
