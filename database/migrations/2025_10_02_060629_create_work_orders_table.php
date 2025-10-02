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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id(); // ID único autoincremental
            $table->string('title'); // Título breve de la orden
            $table->text('description')->nullable(); // Descripción detallada
            $table->unsignedBigInteger('assigned_to')->nullable(); // ID del técnico asignado
            $table->enum('status', ['pendiente', 'en_progreso', 'completada', 'cancelada'])
                  ->default('pendiente'); // Estado de la orden
            $table->dateTime('due_date')->nullable(); // Fecha límite
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
