<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'contrasena',
        'rol',
        'total_reportes',
        'reputacion_usuario'
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    /**
     * Laravel espera el password en "password".
     * Nosotros lo tenemos en "contrasena".
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    /**
     * Opcional: confirmamos que el "username" de login sea el correo.
     */
    public function getAuthIdentifierName()
    {
        return 'correo';
    }

    /**
     * Helper para validar que sea admin.
     */
    public function isAdmin(): bool
    {
        return $this->rol === 'admin';
    }
}
