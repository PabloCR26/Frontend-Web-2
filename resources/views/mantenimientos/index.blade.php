<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>RentaCar | Mantenimientos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">

        @include('layouts.navbar')
        @include('layouts.sidebar')

        <main class="app-main">

            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Gestión de Mantenimientos</h3>
                        </div>
                        <div class="col-sm-6 text-end">
                            @can('create', \App\Models\Maintenance::class)
                                <a href="{{ route('mantenimientos.create') }}" class="btn btn-primary shadow-sm">
                                    <i class="bi bi-tools me-1"></i> Registrar Mantenimiento
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    @can('viewAny', \App\Models\Maintenance::class)
                        
                        {{-- ALERTAS CON ESTILO --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error') || $errors->any())
                            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> 
                                {{ session('error') ?? $errors->first('api') ?? 'Ocurrió un error inesperado.' }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="card card-info card-outline shadow-sm mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Historial y Órdenes Activas</h5>
                            </div>
                            
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" style="width: 50px;">#</th>
                                                <th>Vehículo</th>
                                                <th>Tipo</th>
                                                <th>Fecha Inicio</th>
                                                <th>Fecha Cierre</th>
                                                <th>Costo</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center" style="width: 150px;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($mantenimientos as $m)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    
                                                    <td>
                                                        <span class="fw-bold fs-6">{{ $m['vehiculo_placa'] ?? 'N/A' }}</span><br>
                                                        <small class="text-muted">{{ $m['vehiculo_marca'] ?? '' }} {{ $m['vehiculo_modelo'] ?? '' }}</small>
                                                    </td>
                                                    
                                                    <td>
                                                        @if($m['type'] === 'preventive' || strtolower($m['type']) === 'preventivo')
                                                            <span class="badge bg-info text-dark px-2 py-1"><i class="bi bi-shield-check"></i> Preventivo</span>
                                                        @else
                                                            <span class="badge bg-warning text-dark px-2 py-1"><i class="bi bi-wrench-adjustable"></i> Correctivo</span>
                                                        @endif
                                                    </td>
                                                    
                                                    <td>
                                                        <i class="bi bi-calendar-event text-muted me-1"></i> 
                                                        {{ !empty($m['start_date']) ? \Carbon\Carbon::parse($m['start_date'])->format('d/m/Y') : 'N/A' }}
                                                    </td>
                                                    
                                                    <td>
                                                        @if(!empty($m['end_date']))
                                                            <i class="bi bi-calendar-check text-success me-1"></i> 
                                                            {{ \Carbon\Carbon::parse($m['end_date'])->format('d/m/Y') }}
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    
                                                    <td class="fw-medium text-success">
                                                        ${{ number_format($m['cost'] ?? 0, 2) }}
                                                    </td>
                                                    
                                                    <td class="text-center">
                                                        @if($m['status'] === 'open')
                                                            <span class="badge text-bg-danger px-3 py-2 rounded-pill">Abierto</span>
                                                        @else
                                                            <span class="badge text-bg-success px-3 py-2 rounded-pill">Cerrado</span>
                                                        @endif
                                                    </td>
                                                    
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center gap-1">
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
                                                                        <i class="bi bi-pencil-square"></i>
                                                                    </a>
                                                                @endcan
                                                                
                                                                @can('delete', [\App\Models\Maintenance::class, $m])
                                                                    <form action="{{ route('mantenimientos.destroy', $m['id']) }}"
                                                                        method="POST" class="d-inline"
                                                                        onsubmit="return confirm('¿Está seguro de eliminar este mantenimiento?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                                            <i class="bi bi-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                @endcan
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted py-5">
                                                        <i class="bi bi-tools fs-1 d-block mb-3 text-secondary"></i>
                                                        <h5 class="fw-light">No hay mantenimientos registrados.</h5>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger shadow-sm mt-3">
                            <i class="bi bi-shield-lock-fill me-2"></i> No tienes permiso para ver el módulo de mantenimientos.
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