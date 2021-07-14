<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompraModel extends Model
{
    use HasFactory;
    protected $table        = 'orden_compra';
    protected $primaryKey   = 'ID_Ordc';
}
