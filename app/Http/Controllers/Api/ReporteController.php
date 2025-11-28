<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reporte;
use App\Models\Area;
use App\Models\Usuario;

class ReporteController extends Controller
{

    // MOSTRAR TODOS
    public function index()
    {
        $reportes = Reporte::with(['usuario','area','tipo'])->get();
        return response()->json($reportes, 200);
    }

    // ✅ CREAR REPORTE (SI NO EXISTE ÁREA LA CREA)
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario'    => 'required|integer|exists:usuarios,id_usuario',
            'codigo_postal' => 'required|string',
            'id_tipo'       => 'required|exists:tipos_reporte,id_tipo',
            'descripcion'   => 'required|string',
            'latitud'        => 'required|numeric',
            'longitud'       => 'required|numeric',
            'severidad'      => 'required|integer|min:1|max:5'
        ]);

        $usuario = Usuario::find($request->id_usuario);

        if (!$usuario) {
            return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
        }

        // Buscar área por código postal
        $area = Area::where('codigo_postal', $request->codigo_postal)->first();

        if (!$area) {
            $area = Area::create([
                'codigo_postal' => $request->codigo_postal,
                'colonia'       => $request->colonia ?? 'Sin dato',
                'ciudad'        => $request->ciudad ?? 'Sin dato',
                'estado'        => $request->estado ?? 'Sin dato',
                'latitud'       => $request->latitud,
                'longitud'      => $request->longitud
            ]);
        }

        $reporte = Reporte::create([
            'id_usuario' => $usuario->id_usuario,
            'id_area'    => $area->id_area,
            'id_tipo'    => $request->id_tipo,
            'descripcion'=> $request->descripcion,
            'latitud'    => $request->latitud,
            'longitud'   => $request->longitud,
            'severidad'  => $request->severidad,
            'imagen_url' => $request->imagen_url ?? null
        ]);

        return response()->json([
            'mensaje' => 'Reporte creado correctamente',
            'reporte' => $reporte
        ], 201);
    }

    // MOSTRAR UN REPORTE
    public function show(Request $request)
    {
        $request->validate([
            'id_reporte' => 'required|exists:reportes,id_reporte'
        ]);

        $reporte = Reporte::with(['usuario','area','tipo'])
                    ->where('id_reporte', $request->id_reporte)
                    ->first();

        return response()->json($reporte, 200);
    }

    // ELIMINAR REPORTE
    public function destroy(Request $request)
    {
        $request->validate([
            'id_reporte' => 'required|exists:reportes,id_reporte'
        ]);

        Reporte::where('id_reporte', $request->id_reporte)->delete();

        return response()->json(['mensaje' => '✅ Reporte eliminado'], 200);
    }

    // ✅ REPORTES POR USUARIO (por ID)
    public function reportesPorUsuario(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario'
        ]);

        $usuario = Usuario::find($request->id_usuario);

        $reportes = Reporte::with(['area','tipo'])
            ->where('id_usuario', $usuario->id_usuario)
            ->orderBy('fecha_reporte','desc')
            ->get();

        return response()->json([
            'usuario' => $usuario->nombre,
            'total' => $reportes->count(),
            'reportes' => $reportes
        ]);
    }

    // ✅ REPORTES POR ÁREA
    public function reportesPorArea(Request $request)
    {
        $request->validate([
            'id_area' => 'required|exists:areas,id_area'
        ]);

        $area = Area::find($request->id_area);

        $reportes = Reporte::with(['usuario','tipo'])
            ->where('id_area', $area->id_area)
            ->orderBy('fecha_reporte','desc')
            ->get();

        if ($reportes->isEmpty()) {
            return response()->json(['mensaje'=>'No hay reportes'],404);
        }

        return response()->json([
            'area' => $area,
            'total' => $reportes->count(),
            'reportes' => $reportes
        ],200);
    }
}
