<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleIngresoModel extends Model
{
    use HasFactory;
    protected   $table          = 'detalle_ingreso';
    protected   $primaryKey     = null;
    public      $incrementing   = false;
}
