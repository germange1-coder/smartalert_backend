<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Moderación - SmartAlert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-danger px-3">
    <span class="navbar-brand">Panel Admin - Historial de Moderación</span>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.moderacion.index') }}" class="btn btn-outline-light btn-sm">
            Pendientes
        </a>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn btn-outline-light btn-sm">Cerrar sesión</button>
        </form>
    </div>
</nav>

<div class="container mt-4">

    <h4>Historial de moderaciones</h4>

    <div class="card mt-3">
        <div class="card-body">

            @if($historial->isEmpty())
                <p class="text-muted mb-0">No hay moderaciones registradas.</p>
            @else
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Reporte</th>
                            <th>Usuario</th>
                            <th>Tipo</th>
                            <th>Acción</th>
                            <th>Motivo</th>
                            <th>Admin</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historial as $m)
                            <tr>
                                <td>{{ $m->id_moderacion }}</td>
                                <td>#{{ $m->id_reporte }}</td>
                                <td>{{ $m->reporte->usuario->nombre ?? 'N/A' }}</td>
                                <td>{{ $m->reporte->tipo->nombre_tipo ?? 'N/A' }}</td>
                                <td>
                                    @if($m->accion === 'aprobado')
                                        <span class="badge bg-success">Aprobado</span>
                                    @else
                                        <span class="badge bg-danger">Rechazado</span>
                                    @endif
                                </td>
                                <td>{{ $m->motivo ?? '—' }}</td>
                                <td>{{ $m->admin->nombre ?? 'N/A' }}</td>
                                <td>{{ $m->fecha_modificacion }}</td>
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
