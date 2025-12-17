<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle Reporte - SmartAlert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-danger px-3">
    <a class="navbar-brand" href="{{ route('admin.moderacion.index') }}">⬅ Volver</a>
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button class="btn btn-outline-light btn-sm">Cerrar sesión</button>
    </form>
</nav>

<div class="container mt-4">

    <h4>Reporte #{{ $reporte->id_reporte }}</h4>

    <div class="card mt-3">
        <div class="card-body">
            <p><b>Usuario:</b> {{ $reporte->usuario->nombre ?? 'N/A' }}</p>
            <p><b>Tipo:</b> {{ $reporte->tipo->nombre_tipo ?? 'N/A' }}</p>
            <p><b>Descripción:</b> {{ $reporte->descripcion }}</p>
            <p><b>Severidad:</b> {{ $reporte->severidad }}</p>
            <p><b>Estado:</b> {{ $reporte->estado }}</p>
            <p><b>Ubicación:</b> {{ $reporte->latitud }}, {{ $reporte->longitud }}</p>

            @if($reporte->imagen_url)
                <div class="mt-3">
                    <b>Imagen:</b><br>
                    <img src="{{ asset($reporte->imagen_url) }}" style="max-width: 400px;" class="img-fluid rounded">
                </div>
            @endif
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.moderacion.action', $reporte->id_reporte) }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Motivo (si rechazas)</label>
                    <textarea class="form-control" name="motivo" rows="3"></textarea>
                </div>

                <button name="accion" value="aprobado" class="btn btn-success">Aprobar</button>
                <button name="accion" value="rechazado" class="btn btn-danger">Rechazar</button>
            </form>
        </div>
    </div>

</div>
</body>
</html>
