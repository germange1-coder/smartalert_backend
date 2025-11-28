<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoReporte extends Model
{
    protected $table = 'tipos_reporte';
    protected $primaryKey = 'id_tipo';

    protected $fillable = ['nombre_tipo'];
}
