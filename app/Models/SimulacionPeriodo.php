<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimulacionPeriodo extends Model
{
    protected $table = 'simulacion_periodos';

    protected $fillable = [
        'simulacion_id',
        'periodo',
        'nro_ventas'
    ];

    // Relación inversa
    public function simulacion()
    {
        return $this->belongsTo(Simulacion::class);
    }
}
