<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adoptions', function (Blueprint $table) {
            $table->id();
            $table->string('direccion')->nullable();
            $table->decimal('latitud', 10, 7)->nullable();
            $table->decimal('longitud', 10, 7)->nullable();
            $table->text('detalle')->nullable();
            $table->boolean('aprobada')->default(false);
            $table->foreignId('administrador_usuario_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('adoptante_persona_id');
            $table->index('adoptante_persona_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adoptions');
    }
};


