<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>RentaCar | Rutas</title>
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
                            <h3 class="mb-0">Gestión de Rutas</h3>
                        </div>
                        <div class="col-sm-6 text-end">
                            @can('create', \App\Models\Route::class)
                                <a href="{{ route('rutas.create') }}" class="btn btn-primary shadow-sm">
                                    <i class="bi bi-plus-circle me-1"></i> Nueva Ruta
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    @can('viewAny', \App\Models\Route::class)
                        
                        {{-- ALERTAS --}}
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
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Catálogo de Rutas</h5>
                                    <span class="badge text-bg-secondary px-2 py-1">
                                        {{ count($rutas ?? []) }} registradas
                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" style="width: 50px;">#</th>
                                                <th>Nombre de la Ruta</th>
                                                <th>Punto de Inicio</th>
                                                <th>Punto de Destino</th>
                                                <th>Descripción</th>
                                                <th class="text-center" style="width: 150px;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($rutas ?? [] as $ruta)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    
                                                    <td class="fw-bold text-primary">
                                                        {{ $ruta['name'] ?? 'N/D' }}
                                                    </td>
                                                    
                                                    <td>
                                                        <i class="bi bi-geo-alt text-success me-1"></i> {{ $ruta['start_point'] ?? 'N/D' }}
                                                    </td>
                                                    
                                                    <td>
                                                        <i class="bi bi-geo-fill text-danger me-1"></i> {{ $ruta['end_point'] ?? 'N/D' }}
                                                    </td>
                                                    
                                                    <td class="text-muted small">
                                                        {{ \Illuminate\Support\Str::limit($ruta['description'] ?? 'Sin descripción', 50) }}
                                                    </td>
                                                    
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center gap-1">
                                                            @can('view', [\App\Models\Route::class, $ruta])
                                                                <a href="{{ route('rutas.show', $ruta['id']) }}"
                                                                    class="btn btn-sm btn-outline-secondary" title="Ver detalle">
                                                                    <i class="bi bi-eye"></i>
                                                                </a>
                                                            @endcan
                                                            
                                                            @can('update', [\App\Models\Route::class, $ruta])
                                                                <a href="{{ route('rutas.edit', $ruta['id']) }}"
                                                                    class="btn btn-sm btn-outline-primary" title="Editar">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </a>
                                                            @endcan
                                                            
                                                            @can('delete', [\App\Models\Route::class, $ruta])
                                                                <form action="{{ route('rutas.destroy', $ruta['id']) }}"
                                                                    method="POST" class="d-inline"
                                                                    onsubmit="return confirm('¿Está seguro de eliminar esta ruta?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endcan
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-5">
                                                        <i class="bi bi-map fs-1 d-block mb-3 text-secondary"></i>
                                                        <h5 class="fw-light">No hay rutas registradas en el sistema.</h5>
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
                            <i class="bi bi-shield-lock-fill me-2"></i> No tienes permiso para ver el módulo de rutas.
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