<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Moderacion;
use App\Models\Reporte;

class ModeracionController extends Controller
{
    public function aprobar(Request $request)
    {
        $request->validate([
            'id_reporte' => 'required|exists:reportes,id_reporte',
            'id_admin' => 'required|exists:usuarios,id_usuario',
            'accion' => 'required|in:aprobado,rechazado',
            'motivo' => 'nullable|string'
        ]);

        Moderacion::create($request->all());

        Reporte::where('id_reporte', $request->id_reporte)
               ->update(['estado' => $request->accion]);

        return response()->json([
            'mensaje' => ' Moderación realizada'
        ]);
    }
}
