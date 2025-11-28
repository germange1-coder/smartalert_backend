<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';
    protected $primaryKey = 'id_area';
    public $timestamps = false;


    protected $fillable = [
        'codigo_postal',
        'colonia',
        'ciudad',
        'estado',
        'latitud',
        'longitud',
        'total_reportes',
        'indice_peligro',
        'nivel_reputacion'
    ];
}
