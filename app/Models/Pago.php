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
        'cliente_id',
        'monto',
        'metodo_pago',
        'referencia',
        'comentarios',
        'estado'
    ];

    /**
     * Get the cliente associated with the payment.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
