<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipoReporte;

class TipoReporteController extends Controller
{
    public function index()
    {
        return response()->json([
            'ok' => true,
            'tipos' => TipoReporte::select('id_tipo', 'nombre_tipo')->get()
        ]);
    }
}
