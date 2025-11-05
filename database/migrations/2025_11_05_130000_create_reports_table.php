<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('reporte_id');
            $table->integer('reportador_id');
            $table->integer('cantidad_animales');
            $table->float('longitud');
            $table->float('latitud');
            $table->string('direccion');
            $table->integer('centro_id');
            $table->string('aprobado_id')->nullable();
            $table->string('detalle_aprobado')->nullable();
            $table->date('fecha_creacion')->nullable();
            $table->date('fecha_actualizacion')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};