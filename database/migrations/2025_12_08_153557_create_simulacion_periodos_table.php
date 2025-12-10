<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('simulacion_periodos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('simulacion_id');
            $table->integer('periodo'); // Ej: 0, 1, 2, 3, etc.
            $table->decimal('nro_ventas', 12, 2);
            $table->timestamps();

            $table->foreign('simulacion_id')
                ->references('id')->on('simulaciones')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('simulacion_periodos');
    }
};

