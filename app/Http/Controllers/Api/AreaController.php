<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{
    //  LISTAR TODAS LAS ÁREAS
    public function index()
    {
        return response()->json(Area::all(), 200);
    }

    //  CREAR ÁREA
    public function store(Request $request)
    {
        $request->validate([
            'codigo_postal' => 'required|string|unique:areas,codigo_postal',
            'colonia' => 'nullable|string',
            'ciudad' => 'nullable|string',
            'estado' => 'nullable|string',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric'
        ]);

        $area = Area::create($request->all());

        return response()->json([
            'mensaje' => ' Área creada correctamente',
            'area' => $area
        ], 201);
    }

    //  MOSTRAR ÁREA
    public function show($id)
    {
        $area = Area::find($id);

        if (!$area) {
            return response()->json(['mensaje' => ' Área no encontrada'], 404);
        }

        return response()->json($area, 200);
    }

    //  ELIMINAR ÁREA
    public function destroy($id)
    {
        $area = Area::find($id);

        if (!$area) {
            return response()->json(['mensaje' => ' Área no encontrada'], 404);
        }

        $area->delete();

        return response()->json(['mensaje' => ' Área eliminada'], 200);
    }
}

