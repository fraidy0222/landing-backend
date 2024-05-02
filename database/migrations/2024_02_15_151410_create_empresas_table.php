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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200)->nullable();
            $table->string('alias', 50)->nullable();
            $table->string('logo')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('direccion', 200)->nullable();
            $table->string('correo', 150)->nullable();
            $table->string('director', 100)->nullable();
            $table->string('slogan', 255)->nullable();
            $table->string('resumen', 255)->nullable();
            $table->string('facebook', 50)->nullable();
            $table->string('youtube', 50)->nullable();
            $table->string('twitter', 50)->nullable();
            $table->string('linkedin', 50)->nullable();
            $table->string('video_institucional')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
