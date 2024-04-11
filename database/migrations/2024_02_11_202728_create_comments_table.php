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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_comentario')->nullable();
            $table->string('correo_comentario')->nullable();
            $table->string('user_comentario')->nullable();
            $table->string('comentario');
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('noticia_id');
            $table->unsignedBigInteger('estado_id');

            $table->foreign('noticia_id')
                ->references('id')
                ->on('noticias')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('estado_id')
                ->references('id')
                ->on('estados')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
