<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('simulaciones', function (Blueprint $table) {
            $table->id();
            $table->enum('periodo_nombre', ['dia', 'mes', 'año']);
            $table->integer('venta_inicial'); // n° ventas del primer período
            $table->decimal('tasa_descuento', 5, 2); // porcentaje Ej: 2.5%
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('simulaciones');
    }
};
