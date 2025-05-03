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
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->string('asunto');
            $table->text('descripcion')->nullable();
            $table->decimal('importe', 10, 2);
            $table->enum('estado_pago', ['Pendiente', 'Pagado'])->default('Pendiente');
            $table->enum('estado_orden', ['Pendiente', 'En progreso', 'Completada', 'Cancelada'])->default('Pendiente');
            $table->enum('tipo_trabajo', ['Desarrollo', 'Soporte técnico'])->default('Desarrollo');
            $table->timestamps();
            
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};
