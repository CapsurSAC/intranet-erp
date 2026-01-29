<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $fillable = [
        'dni',
        'cliente',
        'email',
        'asesor',
        'curso',
        'asesor',
        'fecha_venta',
    ];
}
