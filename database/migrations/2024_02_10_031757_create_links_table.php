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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('enlace')->nullable();
            $table->unsignedBigInteger('categoria_enlace_id');

            $table->foreign('categoria_enlace_id')
                ->references('id')
                ->on('categoria_enlaces')
                // ->onDelete('cascade');
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
