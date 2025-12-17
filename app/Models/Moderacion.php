<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moderacion extends Model
{
    protected $table = 'moderacion';
    protected $primaryKey = 'id_moderacion';

    public $timestamps = false; // ✅ IMPORTANTE: tu tabla no tiene created_at/updated_at

    protected $fillable = [
        'id_reporte',
        'id_admin',
        'accion',
        'motivo'
    ];

    // Relación con reporte
    public function reporte()
    {
        return $this->belongsTo(Reporte::class, 'id_reporte', 'id_reporte');
    }

    // Relación con admin (usuario que moderó)
    public function admin()
    {
        return $this->belongsTo(Usuario::class, 'id_admin', 'id_usuario');
    }
}
