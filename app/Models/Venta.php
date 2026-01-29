<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    
    // ESTA LÍNEA ES LA CLAVE: Permite que entre CUALQUIER COSA a la base de datos
    protected $guarded = []; 

    protected $casts = [
        'data' => 'array'
    ];
}