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
        Schema::create('noticias_categoria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('noticia_id');
            $table->foreign('noticia_id')->references('id')->on('noticias')->onDelete('cascade');

            $table->unsignedBigInteger('categoria_noticia_id');
            $table->foreign('categoria_noticia_id')
                ->references('id')
                ->on('categoria_noticias')
                // ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noticias_categoria');
    }
};
