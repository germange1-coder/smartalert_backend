<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moderacion extends Model
{
    protected $table = 'moderacion';
    protected $primaryKey = 'id_moderacion';

    protected $fillable = [
        'id_reporte',
        'id_admin',
        'accion',
        'motivo'
    ];
}
