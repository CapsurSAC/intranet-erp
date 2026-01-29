<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    // Nombre de la tabla (asegúrate de que sea este)
    protected $table = 'ventas';

    /**
     * ATRIBUTOS QUE SE PUEDEN CARGAR MASIVAMENTE
     * Aquí es donde debes agregar 'cliente' y los demás.
     * Si no están aquí, Laravel los ignora y lanza el Warning.
     */
    protected $fillable = [
        'dni',
        'cliente',     // El nombre del cliente
        'email',       // Su correo
        'asesor',      // El asesor de ventas
        'curso',       // El producto o curso
        'celular',     // Número de contacto
        'fecha_venta', // Fecha de la operación
    ];

    /**
     * Si prefieres no restringir nada (solo para desarrollo), 
     * puedes usar guarded en lugar de fillable:
     * protected $guarded = []; 
     */
}