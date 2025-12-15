<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    //  LISTAR TODOS LOS USUARIOS
    public function index()
    {
        return response()->json(Usuario::all(), 200);
    }

    //  CREAR USUARIO
    public function store(Request $request)
    {
        $request->validate([
            'nombre'     => 'required|string|max:100',
            'correo'     => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|string|min:6',
            'rol'        => 'nullable|in:usuario,admin'
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->contrasena),
            'rol' => $request->rol ?? 'usuario',
            'total_reportes' => 0,
            'reputacion_usuario' => 100
        ]);

        return response()->json([
            'mensaje' => ' Usuario creado correctamente',
            'usuario' => $usuario
        ], 201);
    }

    //  MOSTRAR USUARIO POR ID (DESDE JSON)
    public function show(Request $request)
    {
        $usuario = Usuario::find($request->id);

        if (!$usuario) {
            return response()->json([
                'mensaje' => ' Usuario no encontrado'
            ], 404);
        }

        return response()->json($usuario, 200);
    }

    //  ACTUALIZAR USUARIO (ID EN JSON)
    public function update(Request $request)
    {
        $request->validate([
            'id'         => 'required|integer|exists:usuarios,id_usuario',
            'nombre'     => 'nullable|string|max:100',
            'correo'     => 'nullable|email|unique:usuarios,correo,' . $request->id . ',id_usuario',
            'contrasena' => 'nullable|string|min:6',
            'rol'        => 'nullable|in:usuario,admin'
        ]);

        $usuario = Usuario::find($request->id);

        if ($request->filled('contrasena')) {
            $request->merge([
                'contrasena' => Hash::make($request->contrasena)
            ]);
        }

        $usuario->update($request->only([
            'nombre',
            'correo',
            'contrasena',
            'rol'
        ]));

        return response()->json([
            'mensaje' => ' Usuario actualizado correctamente',
            'usuario' => $usuario
        ], 200);
    }

    //  ELIMINAR USUARIO (ID EN JSON)
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:usuarios,id_usuario'
        ]);

        $usuario = Usuario::find($request->id);

        $usuario->delete();

        return response()->json([
            'mensaje' => ' Usuario eliminado correctamente'
        ], 200);
    }
    
    public function buscarPorCorreo(Request $request)
{
    $request->validate([
        'correo' => 'required|email'
    ]);

    $usuario = Usuario::where('correo', $request->correo)->first();

    if (!$usuario) {
        return response()->json([
            'mensaje' => 'Usuario no encontrado'
        ], 404);
    }

    return response()->json($usuario, 200);
}

    
}
