<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>RentaCar | Detalle Vehiculo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

@php
    $item = $vehiculo['data'] ?? $vehiculo;
    $status = $item['status'] ?? '';

    $badgeClass = match($status) {
        'available' => 'text-bg-success',
        'assigned' => 'text-bg-primary',
        'maintenance' => 'text-bg-warning',
        default => 'text-bg-secondary',
    };

    $statusLabel = match($status) {
        'available' => 'Disponible',
        'assigned' => 'Alquilado',
        'maintenance' => 'Mantenimiento',
        default => 'Desconocido',
    };

    $apiHost = 'http://127.0.0.1:8000';
    
    $cleanPath = str_replace('public/', '', $item['image'] ?? '');
    
    if (!empty($cleanPath)) {
        $image = $apiHost . '/storage/' . $cleanPath;
    } else {
        $image = 'https://placehold.co/900x500/e2e8f0/475569?text=Sin+Imagen';
    }
@endphp

<div class="app-wrapper">

@include('layouts.navbar')
@include('layouts.sidebar')

<main class="app-main">

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detalle del Vehiculo</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <img src="{{ $image }}"
                                 class="img-fluid rounded border w-100 shadow-sm"
                                 style="height: 400px; object-fit: cover;"
                                 onerror="this.src='https://placehold.co/900x500/e2e8f0/475569?text=Error+al+cargar+imagen'">
                        </div>

                        <div class="col-lg-6">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h1 class="display-5 fw-bold mb-0">{{ $item['brand'] ?? 'Sin marca' }}</h1>
                                    <h3 class="text-muted">{{ $item['model'] ?? 'Sin modelo' }}</h3>
                                </div>

                                <span class="badge {{ $badgeClass }} fs-5 px-3 py-2">
                                    {{ $statusLabel }}
                                </span>
                            </div>

                            <hr>

                            <div class="row g-4 py-2">
                                <div class="col-sm-6">
                                    <div class="text-muted small">Placa</div>
                                    <div class="fs-5 fw-bold">{{ $item['plate'] ?? 'N/D' }}</div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="text-muted small">Año</div>
                                    <div class="fs-5 fw-bold">{{ $item['year'] ?? 'N/D' }}</div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="text-muted small">Tipo de Vehículo</div>
                                    <div class="fs-5 fw-bold text-capitalize">{{ $item['type'] ?? 'N/D' }}</div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="text-muted small">Capacidad</div>
                                    <div class="fs-5 fw-bold">{{ $item['capacity'] ?? 'N/D' }} personas</div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="text-muted small">Combustible</div>
                                    <div class="fs-5 fw-bold text-capitalize">{{ $item['fuel_type'] ?? 'N/D' }}</div>
                                </div>
                            </div>

                            <div class="mt-5 d-flex gap-2 flex-wrap">
                                @can('update', [\App\Models\Vehicle::class, $item])
                                    <a href="{{ route('vehiculos.edit', $item['id']) }}"
                                       class="btn btn-primary btn-lg px-4">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>
                                @endcan

                                {{-- REQUERIMIENTO F.6: BLOQUEO ASIGNACIÓN --}}
                                @can('update', [\App\Models\VehicleRequest::class, $item])
                                    @if($status == 'maintenance')
                                        <button class="btn btn-secondary btn-lg px-4" title="Vehículo en taller" disabled>
                                            <i class="bi bi-person-x"></i> No Asignable
                                        </button>
                                    @else
                                        <a href="{{ route('solicitudes.create', ['vehiculo' => $item['id'], 'accion' => 'asignar']) }}"
                                           class="btn btn-success btn-lg px-4">
                                            <i class="bi bi-person-check"></i> Asignar
                                        </a>
                                    @endif
                                @endcan

                                {{-- REQUERIMIENTO F.6: BLOQUEO SOLICITUD --}}
                                @can('create', \App\Models\VehicleRequest::class)
                                    @if($status == 'maintenance')
                                        <button class="btn btn-secondary btn-lg px-4" title="Vehículo en taller" disabled>
                                            <i class="bi bi-send-x"></i> No Disponible
                                        </button>
                                    @else
                                        <a href="{{ route('solicitudes.create', ['vehiculo' => $item['id'], 'accion' => 'solicitar']) }}"
                                           class="btn btn-success btn-lg px-4">
                                            <i class="bi bi-send"></i> Solicitar
                                        </a>
                                    @endif
                                @endcan

                                {{-- BLOQUEO: NO MANDAR A MANTENIMIENTO SI YA ESTÁ AHÍ --}}
                                @can('create', \App\Models\Maintenance::class)
                                    @if($status == 'maintenance')
                                        <button class="btn btn-secondary btn-lg px-4" title="El vehículo ya se encuentra en mantenimiento" disabled>
                                            <i class="bi bi-tools"></i> En Taller
                                        </button>
                                    @else
                                        <a href="{{ route('mantenimientos.create', ['vehicle_id' => $item['id']]) }}"
                                           class="btn btn-warning btn-lg px-4">
                                            <i class="bi bi-tools"></i> Mantenimiento
                                        </a>
                                    @endif
                                @endcan
                            </div>

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