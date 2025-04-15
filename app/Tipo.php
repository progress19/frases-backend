<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model {

	protected $table = "tipos";
    
    /**
     * The phrases that belong to this type.
     */
    public function frases()
    {
        return $this->belongsToMany(\App\Models\Frase::class, 'frases_pivot_tipos', 'tipo_id', 'frase_id')
                    ->withPivot('created_at');
    }
}
