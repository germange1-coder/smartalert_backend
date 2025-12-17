<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Moderación - SmartAlert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-danger px-3 d-flex justify-content-between">
    <span class="navbar-brand">Panel Admin - Moderación</span>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.moderacion.historial') }}" class="btn btn-outline-light btn-sm">
            Historial
        </a>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn btn-outline-light btn-sm">Cerrar sesión</button>
        </form>
    </div>
</nav>


<div class="container mt-4">

    @if(session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
    @endif

    <h4>Reportes pendientes</h4>

    <div class="card mt-3">
        <div class="card-body">
            @if($pendientes->isEmpty())
                <p class="text-muted mb-0">No hay reportes pendientes.</p>
            @else
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendientes as $r)
                            <tr>
                                <td>{{ $r->id_reporte }}</td>
                                <td>{{ $r->usuario->nombre ?? 'N/A' }}</td>
                                <td>{{ $r->tipo->nombre_tipo ?? 'N/A' }}</td>
                                <td>{{ $r->fecha_reporte }}</td>
                                <td>
                                    <a class="btn btn-sm btn-primary"
                                       href="{{ route('admin.moderacion.show', $r->id_reporte) }}">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

</div>
</body>
</html>
