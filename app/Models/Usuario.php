<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false; // 👈 ESTO ES CLAVE

    protected $fillable = [
        'nombre',
        'correo',
        'contrasena',
        'rol',
        'total_reportes',
        'reputacion_usuario'
    ];

    protected $hidden = ['contrasena'];
}

