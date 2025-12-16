<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $table = 'reportes';
    protected $primaryKey = 'id_reporte';
    public $incrementing = true;  // si tu id es autoincremental
    protected $keyType = 'int';
    public $timestamps = false; 
    
    protected $fillable = [
        'id_usuario',
        'id_area',
        'id_tipo',
        'descripcion',
        'latitud',
        'longitud',
        'severidad',
        'imagen_url'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id_area');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoReporte::class, 'id_tipo', 'id_tipo');
    }
}
