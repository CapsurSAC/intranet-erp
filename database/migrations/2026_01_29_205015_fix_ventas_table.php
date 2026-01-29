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
    Schema::table('ventas', function (Blueprint $table) {
        if (!Schema::hasColumn('ventas', 'cliente')) {
            $table->string('cliente')->nullable();
        }

        if (!Schema::hasColumn('ventas', 'email')) {
            $table->string('email')->nullable();
        }

        if (!Schema::hasColumn('ventas', 'asesor')) {
            $table->string('asesor')->nullable();
        }

        if (!Schema::hasColumn('ventas', 'curso')) {
            $table->string('curso')->nullable();
        }

        if (!Schema::hasColumn('ventas', 'dni')) {
            $table->string('dni')->nullable();
        }

        if (!Schema::hasColumn('ventas', 'celular')) {
            $table->string('celular')->nullable();
        }

        if (!Schema::hasColumn('ventas', 'fecha_venta')) {
            $table->timestamp('fecha_venta')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            //
        });
    }
};
