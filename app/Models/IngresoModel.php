<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoModel extends Model
{
    use HasFactory;
    protected $table        = 'ingreso';
    protected $primaryKey   = 'ID_Ingres';
}
