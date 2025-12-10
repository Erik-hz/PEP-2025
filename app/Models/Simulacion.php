<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simulacion extends Model
{
    protected $table = 'simulaciones';

    protected $fillable = [
        'periodo_nombre',
        'venta_inicial',
        'tasa_descuento'
    ];

    // Una simulación tiene muchos periodos
    public function periodos()
    {
        return $this->hasMany(SimulacionPeriodo::class);
    }
}
