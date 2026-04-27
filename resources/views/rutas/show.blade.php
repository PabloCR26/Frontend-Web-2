<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>RentaCar | Detalle de Ruta</title>
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
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Detalle de Ruta</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="{{ route('rutas.index') }}" class="btn btn-secondary shadow-sm">
                            <i class="bi bi-arrow-left"></i> Volver al listado
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                @can('view', [\App\Models\Route::class, $ruta])
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card card-info card-outline shadow-sm border-0">
                                
                                <div class="card-header">
                                    <h5 class="mb-0 fw-bold">Información de la Trayectoria</h5>
                                </div>
                                
                                <div class="card-body p-4">

                                    <div class="alert alert-light border border-secondary-subtle shadow-sm mb-4 d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                            <i class="bi bi-signpost-split fs-3 text-primary"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-1 fw-bold text-dark">{{ $ruta['name'] ?? 'N/A' }}</h4>
                                            <span class="text-muted fs-6">Ruta de Transporte #{{ $ruta['id'] ?? '' }}</span>
                                        </div>
                                    </div>

                                    <div class="row g-4 position-relative">
                                        
                                        <div class="position-absolute d-none d-sm-block border-start border-2 border-secondary opacity-25" style="left: 23px; top: 40px; bottom: 80px; width: 0;"></div>

                                        <div class="col-12 ms-sm-4">
                                            <div class="text-muted small fw-semibold text-uppercase"><i class="bi bi-circle-fill text-success fs-6 me-2" style="margin-left: -28px; background: white; padding: 2px; border-radius: 50%;"></i> Punto de Partida</div>
                                            <div class="fs-5 fw-medium mt-1">
                                                {{ $ruta['start_point'] ?? 'No definido' }}
                                            </div>
                                        </div>

                                        <div class="col-12 ms-sm-4">
                                            <div class="text-muted small fw-semibold text-uppercase"><i class="bi bi-geo-alt-fill text-danger fs-5 me-2" style="margin-left: -30px; background: white; padding: 2px;"></i> Destino Final</div>
                                            <div class="fs-5 fw-medium mt-1">
                                                {{ $ruta['end_point'] ?? 'No definido' }}
                                            </div>
                                        </div>

                                        <div class="col-12 mt-5">
                                            <div class="text-muted small fw-semibold text-uppercase"><i class="bi bi-card-text me-1"></i> Descripción del Propósito</div>
                                            <div class="p-3 bg-light rounded border mt-1">
                                                {{ $ruta['description'] ?? 'Sin descripción proporcionada.' }}
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                
                                <div class="card-footer bg-white border-top p-3 d-flex gap-2 justify-content-end">
                                    <a href="{{ route('rutas.index') }}" class="btn btn-outline-secondary">Volver</a>
                                    
                                    @can('update', [\App\Models\Route::class, $ruta])
                                        <a href="{{ route('rutas.edit', $ruta['id']) }}" class="btn btn-primary shadow-sm">
                                            <i class="bi bi-pencil-square"></i> Modificar Ruta
                                        </a>
                                    @endcan
                                </div>
                                
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger shadow-sm mt-3">
                        <i class="bi bi-shield-lock-fill me-2"></i> No tienes permiso para ver los detalles de esta ruta.
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