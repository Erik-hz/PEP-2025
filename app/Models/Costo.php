<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Costo extends Model
{
    protected $table = 'costos';

    protected $fillable = [
        'descripcion',
        'monto'
    ];
}
