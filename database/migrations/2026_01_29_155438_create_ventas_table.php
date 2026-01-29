<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();

            // Relación con alumno
            $table->foreignId('alumno_id')
                  ->constrained('alumnos')
                  ->cascadeOnDelete();

            // Redundancia útil (trazabilidad histórica)
            $table->string('dni', 15);

            // Datos comerciales base
            $table->string('curso');
            $table->decimal('monto', 10, 2)->nullable();
            $table->string('medio_pago')->nullable();
            $table->date('fecha_venta')->nullable();

            // Origen del dato
            $table->string('form_origen')->nullable();

            // FICHA COMPLETA DEL FORM (CLAVE)
            $table->json('raw_data');

            $table->timestamps();

            // Índices para consultas rápidas
            $table->index('dni');
            $table->index('curso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
