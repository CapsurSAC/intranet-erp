<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    // 1. Nombre de la tabla en tu DB
    protected $table = 'ventas';

    // 2. EL FILTRO DE SEGURIDAD (Fillable)
    // Agrega aquí 'cliente' y todos los campos que quieres importar.
    // Si no están aquí, Laravel los ignora y lanza el Warning/Error.
    protected $fillable = [
        'dni',
        'cliente',     // <--- Asegúrate que se llame igual que en tu migración
        'email',
        'asesor',
        'curso',
        'celular',
        'fecha_venta',
    ];

    // 3. Desactivar protección si prefieres (Solo si confías plenamente en el CSV)
    // protected $guarded = []; 
}