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

    $image = $item['image']
        ?? 'https://placehold.co/900x500/e2e8f0/475569?text=Vehiculo';
@endphp

<div class="app-wrapper">

@include('layouts.navbar')
@include('layouts.sidebar')

<main class="app-main">

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Detalle del Vehiculo</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <img src="{{ $image }}"
                                 class="img-fluid rounded border w-100"
                                 style="height: 360px; object-fit: cover;">
                        </div>

                        <div class="col-lg-6">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <h2>{{ $item['brand'] ?? 'Sin marca' }}</h2>
                                    <h4 class="text-muted">{{ $item['model'] ?? 'Sin modelo' }}</h4>
                                </div>

                                <span class="badge {{ $badgeClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>

                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <strong>Placa:</strong> {{ $item['plate'] ?? 'N/D' }}
                                </div>

                                <div class="col-sm-6">
                                    <strong>Ano:</strong> {{ $item['year'] ?? 'N/D' }}
                                </div>

                                <div class="col-sm-6">
                                    <strong>Tipo:</strong> {{ $item['type'] ?? 'N/D' }}
                                </div>

                                <div class="col-sm-6">
                                    <strong>Capacidad:</strong> {{ $item['capacity'] ?? 'N/D' }}
                                </div>
                            </div>

                            <div class="mt-4 d-flex gap-2 flex-wrap">
                                @can('update', [\App\Models\Vehicle::class, $item])
                                    <a href="{{ route('vehiculos.edit', $item['id']) }}"
                                       class="btn btn-primary">
                                        Editar
                                    </a>
                                @endcan

                                @can('update', [\App\Models\VehicleRequest::class, $item])
                                    <a href="{{ route('vehiculos.show', ['vehiculo' => $item['id'], 'accion' => 'asignar']) }}"
                                       class="btn btn-success">
                                        Asignar
                                    </a>
                                @endcan

                                @can('create', \App\Models\VehicleRequest::class)
                                    <a href="{{ route('vehiculos.show', ['vehiculo' => $item['id'], 'accion' => 'solicitar']) }}"
                                       class="btn btn-success">
                                        Solicitar
                                    </a>
                                @endcan

                                @can('create', \App\Models\Maintenance::class)
                                    <a href="{{ route('mantenimientos.create', ['vehicle_id' => $item['id']]) }}"
                                       class="btn btn-warning">
                                        Mantenimiento
                                    </a>
                                @endcan

                                <a href="{{ route('vehiculos.index') }}"
                                   class="btn btn-outline-secondary">
                                    Volver
                                </a>
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
