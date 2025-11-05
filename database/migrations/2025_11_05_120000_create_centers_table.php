<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('centers', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('telefono')->nullable();
            $table->float('longitud')->nullable();
            $table->float('latitud')->nullable();
            $table->string('direccion')->nullable();
            $table->integer('capacidad_maxima')->nullable();
            $table->date('fecha_creacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('centers');
    }
};