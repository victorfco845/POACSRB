<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('Nombre', 128);
            $table->string('Apellidos', 128);
            $table->string('Correo_Institucional', 128)->unique();
            $table->integer('Numero_de_Empleado')->unique();
            $table->string('Puesto', 128);
            $table->integer('Nivel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
