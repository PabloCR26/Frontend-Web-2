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
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Detalle de Mantenimiento</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Información del Mantenimiento</span>
                                @if($mantenimiento['status'] === 'open')
                                    <span class="badge bg-danger fs-6">🔴 Abierto</span>
                                @else
                                    <span class="badge bg-success fs-6">✅ Cerrado</span>
                                @endif
                            </div>
                            <div class="card-body">

                                <div class="alert alert-light border mb-4">
                                    <i class="bi bi-truck me-1"></i>
                                    <strong>Vehículo:</strong>
                                    {{ $mantenimiento['vehicle_plate'] }} —
                                    {{ $mantenimiento['vehicle_brand'] }} {{ $mantenimiento['vehicle_model'] }}
                                    ({{ $mantenimiento['vehicle_year'] }})
                                </div>

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="fw-semibold text-muted">Tipo</label>
                                        <p>
                                            @if($mantenimiento['type'] === 'preventive')
                                                <span class="badge bg-info text-dark">Preventivo</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Correctivo</span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="fw-semibold text-muted">Estado</label>
                                        <p>
                                            @if($mantenimiento['status'] === 'open')
                                                <span class="badge bg-danger">Abierto</span>
                                            @else
                                                <span class="badge bg-success">Cerrado</span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="fw-semibold text-muted">Fecha de inicio</label>
                                        <p>{{ \Carbon\Carbon::parse($mantenimiento['start_date'])->format('d/m/Y') }}</p>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="fw-semibold text-muted">Fecha de cierre</label>
                                        <p>
                                            {{ $mantenimiento['end_date']
                                                ? \Carbon\Carbon::parse($mantenimiento['end_date'])->format('d/m/Y')
                                                : '— Pendiente de cierre' }}
                                        </p>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="fw-semibold text-muted">Costo</label>
                                        <p>${{ number_format($mantenimiento['cost'], 2) }}</p>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="fw-semibold text-muted">Descripción</label>
                                        <p>{{ $mantenimiento['description'] ?? '—' }}</p>
                                    </div>

                                </div>

                                @if($mantenimiento['status'] === 'open')
                                    <div class="alert alert-warning">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                        <strong>Vehículo bloqueado:</strong>
                                        Este vehículo no puede ser asignado ni aprobado mientras tenga un mantenimiento abierto.
                                    </div>
                                @endif

                            </div>
                            <div class="card-footer d-flex gap-2">
                                @if($mantenimiento['status'] === 'open')
                                    <a href="{{ route('mantenimientos.edit', $mantenimiento['id']) }}" class="btn btn-primary">
                                        <i class="bi bi-pencil"></i> Editar / Cerrar
                                    </a>
                                @endif
                                <a href="{{ route('mantenimientos.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Volver
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</div>
<script src="{{ asset('js/adminlte.js') }}"></script>
</body>
</html>