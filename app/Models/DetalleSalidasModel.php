<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleSalidasModel extends Model
{
    use HasFactory;
    protected   $table          = 'detalle_salida';
    protected   $primaryKey     = null;
    public      $incrementing   = false;
}
