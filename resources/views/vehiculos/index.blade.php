<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>RentaCar | Vehiculos</title>
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
                <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                        @can('create', \App\Models\Vehicle::class)
                            <a href="{{ route('vehiculos.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Registrar Vehiculo
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <div class="card shadow-sm">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Catalogo de vehiculos</h4>
                            <span class="badge text-bg-secondary">
                                {{ count($vehiculos) }} registrados
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row g-4">
                            @forelse($vehiculos as $vehiculo)
                                @php
                                    $status = $vehiculo['status'] ?? '';

                                    $badgeClass = match($status) {
                                        'available' => 'bg-success',
                                        'assigned' => 'bg-primary',
                                        'maintenance' => 'bg-warning text-dark',
                                        default => 'bg-secondary',
                                    };

                                    $statusLabel = match($status) {
                                        'available' => 'Disponible',
                                        'assigned' => 'Alquilado',
                                        'maintenance' => 'Mantenimiento',
                                        default => 'Desconocido',
                                    };

                                    // --- LÓGICA DE IMAGEN CORREGIDA ---
                                    $apiHost = 'http://127.0.0.1:8000'; // Tu API
                                    
                                    if (!empty($vehiculo['image'])) {
                                        // Limpiamos la ruta por si el back guardó "public/"
                                        $cleanPath = str_replace('public/', '', $vehiculo['image']);
                                        $imagePath = $apiHost . '/storage/' . $cleanPath;
                                    } else {
                                        $imagePath = 'https://placehold.co/700x450/e2e8f0/475569?text=Vehiculo';
                                    }
                                @endphp

                                <div class="col-sm-6 col-xl-4">
                                    <div class="card h-100 shadow-sm">
                                        <img src="{{ $imagePath }}"
                                             class="card-img-top"
                                             style="height: 220px; object-fit: cover;"
                                             onerror="this.src='https://placehold.co/700x450/e2e8f0/475569?text=Error+al+cargar'">

                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h5 class="fw-bold">{{ $vehiculo['brand'] ?? 'Sin marca' }}</h5>
                                                    <small class="text-muted">{{ $vehiculo['model'] ?? 'Sin modelo' }}</small>
                                                </div>

                                                <span class="badge {{ $badgeClass }}">
                                                    {{ $statusLabel }}
                                                </span>
                                            </div>

                                            <div class="small text-muted mt-2">
                                                <div><strong>Placa:</strong> {{ $vehiculo['plate'] ?? 'N/D' }}</div>
                                                <div><strong>Ano:</strong> {{ $vehiculo['year'] ?? 'N/D' }}</div>
                                            </div>
                                        </div>

                                        <div class="card-footer bg-white">
                                            <div class="d-flex justify-content-between flex-wrap gap-2">
                                                <a href="{{ route('vehiculos.show', $vehiculo['id']) }}"
                                                   class="btn btn-outline-secondary btn-sm" title="Ver Detalle">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                @can('update', [\App\Models\Vehicle::class, $vehiculo])
                                                    <a href="{{ route('vehiculos.edit', $vehiculo['id']) }}"
                                                       class="btn btn-outline-primary btn-sm" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                @endcan

                                                @can('update', [\App\Models\VehicleRequest::class, $vehiculo])
                                                    <a href="{{ route('vehiculos.show', ['vehiculo' => $vehiculo['id'], 'accion' => 'asignar']) }}"
                                                       class="btn btn-success btn-sm" title="Asignar">
                                                        <i class="bi bi-person-check"></i>
                                                    </a>
                                                @endcan
                                                
                                                @can('create', \App\Models\VehicleRequest::class)
                                                    <a href="{{ route('vehiculos.show', ['vehiculo' => $vehiculo['id'], 'accion' => 'solicitar']) }}"
                                                       class="btn btn-success btn-sm" title="Solicitar">
                                                        <i class="bi bi-send-check"></i>
                                                    </a>
                                                @endcan

                                                @can('create', \App\Models\Maintenance::class)
                                                    <a href="{{ route('mantenimientos.create', ['vehicle_id' => $vehiculo['id']]) }}"
                                                       class="btn btn-warning btn-sm" title="Mantenimiento">
                                                        <i class="bi bi-tools"></i>
                                                    </a>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted py-5">
                                    <i class="bi bi-car-front display-4"></i>
                                    <p class="mt-2">No hay vehiculos registrados</p>
                                </div>
                            @endforelse
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