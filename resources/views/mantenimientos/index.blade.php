<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>RentaCar | Mantenimientos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

    @include('layouts.navbar')
    @include('layouts.sidebar')

    <main class="app-main">

        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Mantenimientos</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        @can('create', \App\Models\Maintenance::class)
                            <a href="{{ route('mantenimientos.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Registrar Mantenimiento
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                @can('viewAny', \App\Models\Maintenance::class)
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            Listado de Mantenimientos
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Vehiculo</th>
                                            <th>Tipo</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Cierre</th>
                                            <th>Costo</th>
                                            <th>Estado</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($mantenimientos as $m)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>{{ $m['vehicle_plate'] }}</strong><br>
                                                <small class="text-muted">{{ $m['vehicle_brand'] }} {{ $m['vehicle_model'] }}</small>
                                            </td>
                                            <td>
                                                @if($m['type'] === 'preventive')
                                                    <span class="badge bg-info text-dark">Preventivo</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Correctivo</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($m['start_date'])->format('d/m/Y') }}</td>
                                            <td>{{ $m['end_date'] ? \Carbon\Carbon::parse($m['end_date'])->format('d/m/Y') : '-' }}</td>
                                            <td>${{ number_format($m['cost'], 2) }}</td>
                                            <td>
                                                @if($m['status'] === 'open')
                                                    <span class="badge bg-danger">Abierto</span>
                                                @else
                                                    <span class="badge bg-success">Cerrado</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @can('view', [\App\Models\Maintenance::class, $m])
                                                    <a href="{{ route('mantenimientos.show', $m['id']) }}"
                                                       class="btn btn-sm btn-outline-secondary" title="Ver detalle">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @endcan
                                                @if($m['status'] === 'open')
                                                    @can('update', [\App\Models\Maintenance::class, $m])
                                                        <a href="{{ route('mantenimientos.edit', $m['id']) }}"
                                                           class="btn btn-sm btn-outline-primary" title="Editar / Cerrar">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete', [\App\Models\Maintenance::class, $m])
                                                        <form action="{{ route('mantenimientos.destroy', $m['id']) }}"
                                                              method="POST" class="d-inline"
                                                              onsubmit="return confirm('Eliminar este mantenimiento?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                No hay mantenimientos registrados.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger">
                        No tienes permiso para ver mantenimientos.
                    </div>
                @endcan

            </div>
        </div>
    </main>

    @include('layouts.footer')
</div>
<script src="{{ asset('js/adminlte.js') }}"></script>
</body>
</html>
