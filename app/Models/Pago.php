<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pagos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'orden_id',
        'cliente_id',
        'monto',
        'metodo_pago',
        'referencia',
        'comentarios',
        'estado'
    ];

    /**
     * Get the orden associated with the payment.
     */
    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    /**
     * Get the cliente associated with the payment.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
