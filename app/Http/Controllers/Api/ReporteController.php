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

// ✅ CREAR REPORTE (SI NO EXISTE ÁREA LA CREA) + SUBIDA DE IMAGEN
public function store(Request $request)
{
    $request->validate([
        'id_usuario'    => 'required|integer|exists:usuarios,id_usuario',
        'codigo_postal' => 'required|string',
        'id_tipo'       => 'required|exists:tipos_reporte,id_tipo',
        'descripcion'   => 'required|string',
        'latitud'       => 'required|numeric',
        'longitud'      => 'required|numeric',
        'severidad'     => 'required|integer|min:1|max:5',
        'imagen'        => 'nullable|image|mimes:jpg,jpeg,png|max:5120' // max 5MB
    ]);

    $usuario = Usuario::find($request->id_usuario);

    if (!$usuario) {
        return response()->json(['mensaje' => 'Usuario no encontrado'], 404);
    }

    // Buscar área por código postal o crearla
    $area = Area::firstOrCreate(
        ['codigo_postal' => $request->codigo_postal],
        [
            'colonia'  => $request->colonia ?? 'Sin dato',
            'ciudad'   => $request->ciudad ?? 'Sin dato',
            'estado'   => $request->estado ?? 'Sin dato',
            'latitud'  => $request->latitud,
            'longitud' => $request->longitud
        ]
    );

    // Subida de imagen opcional
    $imagenUrl = null;

    if ($request->hasFile('imagen')) {
        // 📌 Guarda directo en storage/app/public/reportes
        $path = $request->file('imagen')->store('reportes', 'public');

        // 📌 URL pública correcta
        $imagenUrl = 'storage/' . $path;
    }

    // Crear reporte
    $reporte = Reporte::create([
        'id_usuario'  => $request->id_usuario,
        'id_area'     => $area->id_area,
        'id_tipo'     => $request->id_tipo,
        'descripcion' => $request->descripcion,
        'latitud'     => $request->latitud,
        'longitud'    => $request->longitud,
        'severidad'   => $request->severidad,
        'imagen_url'  => $imagenUrl
    ]);

    return response()->json([
        'mensaje' => 'Reporte creado exitosamente',
        'reporte' => $reporte
    ]);
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
    //reportes cercanos 
    public function reportesCercanos(Request $request)
{
    $request->validate([
        'latitud' => 'required|numeric',
        'longitud' => 'required|numeric',
        'radio' => 'nullable|numeric' // kilómetros
    ]);

    $lat = $request->latitud;
    $lng = $request->longitud;
    $radio = $request->radio ?? 10; // default 10 km

    $reportes = Reporte::with(['usuario','area','tipo'])
    ->where('estado', 'aprobado') // solo aceptados
    ->selectRaw("*, 
        (6371 * acos(
            cos(radians(?)) *
            cos(radians(latitud)) *
            cos(radians(longitud) - radians(?)) +
            sin(radians(?)) *
            sin(radians(latitud))
        )) AS distancia", [$lat, $lng, $lat])
    ->having('distancia', '<=', $radio)
    ->orderBy('distancia', 'asc')
    ->get();

    return response()->json($reportes);
}

}
