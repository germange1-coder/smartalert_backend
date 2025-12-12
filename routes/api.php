<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ModeracionController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\ReporteController;
use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\TipoReporteController;

// ✅ Verificar que la API funciona
Route::get('/status', function () {
    return response()->json([
        'ok' => true,
        'mensaje' => 'API SmartAlert funcionando'
    ]);
});
Route::get('/listar_usuarios', [UsuarioController::class, 'index']);          // listar
Route::post('/crear_usuario', [UsuarioController::class, 'store']);    // crear
Route::post('/buscar_usuario', [UsuarioController::class, 'show']);    // buscar por id en JSON
Route::put('/actualizar_usuario', [UsuarioController::class, 'update']);           // actualizar por id en JSON
Route::delete('/eliminar_usuario', [UsuarioController::class, 'destroy']);       // eliminar por id en JSON

/* ÁREAS */
Route::get('/listar_areas', [AreaController::class, 'index']);
Route::post('/crear_area', [AreaController::class, 'store']);
Route::post('/buscar_area', [AreaController::class, 'show']);

/* REPORTES */
Route::post('/reportes_cercanos', [ReporteController::class, 'reportesCercanos']);
Route::get('/listar_reportes', [ReporteController::class, 'index']);
Route::post('/crear_reporte', [ReporteController::class, 'store']); // CREA AREA SI NO EXISTE
Route::post('/buscar_reporte', [ReporteController::class, 'show']);
Route::delete('/eliminar_reporte', [ReporteController::class, 'destroy']);
Route::post('/reportes_area', [ReporteController::class, 'reportesPorArea']);
Route::post('/reportes_usuario', [ReporteController::class, 'reportesPorUsuario']);


/* MODERACIÓN */
Route::post('/moderar', [ModeracionController::class, 'aprobar']);

Route::get('/listar_tipos_reporte', [TipoReporteController::class, 'index']);
