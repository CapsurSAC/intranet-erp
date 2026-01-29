<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    // ELIMINAMOS LA PROTECCIÓN DE COLUMNAS
    // Al dejar guarded vacío, permitimos que entre cualquier dato del CSV
    protected $guarded = [];

    // Si quieres usar fillable en lugar de guarded, usa este:
    /*
    protected $fillable = [
        'dni', 'cliente', 'email', 'asesor', 'curso', 'celular', 'fecha_venta'
    ];
    */
}