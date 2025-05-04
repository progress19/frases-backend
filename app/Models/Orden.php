<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ordenes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cliente_id',
        'fecha',
        'asunto',
        'descripcion',
        'importe',
        'estado_pago',
        'estado_orden',
        'tipo_trabajo'
    ];

    /**
     * Get the cliente that owns the orden.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    
    /**
     * Get the pagos for the orden.
     */
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
