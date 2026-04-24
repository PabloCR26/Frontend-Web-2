<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>RentaCar | Detalle Mantenimiento</title>
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
                        <h3 class="mb-0">Detalle de Mantenimiento <span class="text-muted fs-5">#{{ $mantenimiento['id'] ?? '' }}</span></h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="{{ route('mantenimientos.index') }}" class="btn btn-secondary shadow-sm">
                            <i class="bi bi-arrow-left"></i> Volver al listado
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                @can('view', [\App\Models\Maintenance::class, $mantenimiento])
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card card-info card-outline shadow-sm border-0">
                                
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 fw-bold">Información del Mantenimiento</h5>
                                    @if($mantenimiento['status'] === 'open')
                                        <span class="badge bg-danger fs-6 px-3 py-2 rounded-pill shadow-sm"><i class="bi bi-exclamation-circle me-1"></i> Abierto</span>
                                    @else
                                        <span class="badge bg-success fs-6 px-3 py-2 rounded-pill shadow-sm"><i class="bi bi-check-circle me-1"></i> Cerrado</span>
                                    @endif
                                </div>
                                
                                <div class="card-body p-4">

                                    <div class="alert alert-light border border-secondary-subtle shadow-sm mb-4 d-flex align-items-center">
                                        <div class="bg-secondary bg-opacity-10 p-3 rounded me-3">
                                            <i class="bi bi-car-front-fill fs-3 text-secondary"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1 fw-bold text-dark">{{ $mantenimiento['plate'] ?? 'N/A' }}</h5>
                                            <span class="text-muted fs-6">{{ $mantenimiento['brand'] ?? '' }} {{ $mantenimiento['model'] ?? '' }}</span>
                                        </div>
                                    </div>

                                    <div class="row g-4">

                                        <div class="col-sm-6">
                                            <div class="text-muted small fw-semibold text-uppercase"><i class="bi bi-tag me-1"></i> Tipo de Mantenimiento</div>
                                            <div class="mt-1">
                                                @if($mantenimiento['type'] === 'preventive' || strtolower($mantenimiento['type']) === 'preventivo')
                                                    <span class="badge bg-info text-dark px-2 py-1 fs-6"><i class="bi bi-shield-check"></i> Preventivo</span>
                                                @else
                                                    <span class="badge bg-warning text-dark px-2 py-1 fs-6"><i class="bi bi-wrench-adjustable"></i> Correctivo</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="text-muted small fw-semibold text-uppercase"><i class="bi bi-cash-coin me-1"></i> Costo Reportado</div>
                                            <div class="fs-5 fw-bold text-success mt-1">
                                                ${{ number_format($mantenimiento['cost'] ?? 0, 2) }}
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="text-muted small fw-semibold text-uppercase"><i class="bi bi-calendar-event me-1"></i> Fecha de Inicio</div>
                                            <div class="fs-6 fw-medium mt-1">
                                                {{ !empty($mantenimiento['start_date']) ? \Carbon\Carbon::parse($mantenimiento['start_date'])->format('d/m/Y') : 'N/A' }}
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="text-muted small fw-semibold text-uppercase"><i class="bi bi-calendar-check me-1"></i> Fecha de Cierre</div>
                                            <div class="fs-6 fw-medium mt-1">
                                                @if(!empty($mantenimiento['end_date']))
                                                    <span class="text-success">{{ \Carbon\Carbon::parse($mantenimiento['end_date'])->format('d/m/Y') }}</span>
                                                @else
                                                    <span class="text-danger fst-italic">- Pendiente de cierre</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="text-muted small fw-semibold text-uppercase"><i class="bi bi-card-text me-1"></i> Descripción del Trabajo</div>
                                            <div class="p-3 bg-light rounded border mt-1">
                                                {{ $mantenimiento['description'] ?? 'Sin descripción proporcionada.' }}
                                            </div>
                                        </div>

                                    </div>

                                    @if($mantenimiento['status'] === 'open')
                                        <div class="alert alert-warning mt-4 shadow-sm border-warning d-flex align-items-center">
                                            <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                                            <div>
                                                <strong>Vehículo bloqueado:</strong><br>
                                                Este vehículo se encuentra en estado de mantenimiento y no puede ser asignado ni solicitado hasta que esta orden sea cerrada.
                                            </div>
                                        </div>
                                    @endif

                                </div>
                                
                                <div class="card-footer bg-white border-top p-3 d-flex gap-2 justify-content-end">
                                    <a href="{{ route('mantenimientos.index') }}" class="btn btn-outline-secondary">
                                        Volver
                                    </a>
                                    
                                    @if($mantenimiento['status'] === 'open')
                                        @can('update', [\App\Models\Maintenance::class, $mantenimiento])
                                            <a href="{{ route('mantenimientos.edit', $mantenimiento['id']) }}" class="btn btn-primary shadow-sm">
                                                <i class="bi bi-pencil-square"></i> Editar / Cerrar Orden
                                            </a>
                                        @endcan
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger shadow-sm mt-3">
                        <i class="bi bi-shield-lock-fill me-2"></i> No tienes permiso para ver los detalles de este mantenimiento.
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