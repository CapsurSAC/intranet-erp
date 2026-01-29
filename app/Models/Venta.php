<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni',
        'cliente', // <-- Este debe ser igual al que usas en el controlador
        'email',
        'asesor',
        'curso',
        'celular',
        'fecha_venta'
    ];
}