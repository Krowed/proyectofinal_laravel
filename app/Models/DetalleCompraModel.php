<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompraModel extends Model
{
    use HasFactory;
    protected  $table            = 'detalle_compra';
    protected   $primaryKey     = null;
    public      $incrementing   = false;
}
