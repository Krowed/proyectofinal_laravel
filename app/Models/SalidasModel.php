<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidasModel extends Model
{
    use HasFactory;
    protected $table = 'salida';
    protected $primaryKey = 'ID_Salid';
}
