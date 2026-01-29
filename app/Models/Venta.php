<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'dni',
        'cliente',
        'email',
        'curso',
        'asesor',
        'fecha_venta',
    ];
}
