<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clientes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'email',
        'cuit',
        'domicilio',
        'estado'
    ];

    /**
     * Get the ordenes for the cliente.
     */
    public function ordenes()
    {
        return $this->hasMany(Orden::class);
    }
}
