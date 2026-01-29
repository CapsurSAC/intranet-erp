<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    
    // Permitimos que se guarde el campo 'data'
    protected $fillable = ['data'];

    // Esto convierte el JSON de la DB en un array de PHP automáticamente
    protected $casts = [
        'data' => 'array'
    ];
}