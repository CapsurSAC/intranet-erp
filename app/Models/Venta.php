<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    // 1. Nombre de la tabla (asegúrate que sea plural)
    protected $table = 'ventas';

    // 2. LA LISTA BLANCA (Fillable)
    // Si una columna NO está aquí, Laravel mandará un Warning o error de integridad
    protected $fillable = [
        'dni',
        'cliente',     // <--- Este es el campo que te está dando guerra
        'email',
        'asesor',
        'curso',
        'celular',
        'fecha_venta',
    ];

    // 3. CASTEO DE DATOS (Opcional, para manejar la fecha correctamente)
    protected $casts = [
        'fecha_venta' => 'datetime',
    ];
}