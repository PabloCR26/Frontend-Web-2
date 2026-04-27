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
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Gestión de Flota</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        @can('create', \App\Models\Vehicle::class)
                            <a href="{{ route('vehiculos.create') }}" class="btn btn-primary shadow-sm">
                                <i class="bi bi-plus-circle"></i> Registrar Vehiculo
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                {{-- ALERTAS GLOBALES --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error') || $errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> 
                        {{ session('error') ?? $errors->first() ?? 'Ocurrió un error inesperado.' }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body bg-white p-3">
                        <form action="{{ route('vehiculos.index') }}" method="GET">
                            <div class="row g-3 align-items-end">
                                
                                <div class="col-md-3">
                                    <h4 class="mb-1 fw-bold">Catálogo</h4>
                                    <span class="badge text-bg-secondary rounded-pill">
                                        {{ count($vehiculos ?? []) }} resultados
                                    </span>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-calendar-event me-1"></i> Salida (Opcional)</label>
                                    <input type="datetime-local" name="start_datetime" class="form-control form-control-sm" 
                                           value="{{ $start_datetime ?? '' }}">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-calendar-check me-1"></i> Regreso (Opcional)</label>
                                    <input type="datetime-local" name="end_datetime" class="form-control form-control-sm" 
                                           value="{{ $end_datetime ?? '' }}">
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-funnel me-1"></i> Estado Actual</label>
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="">Todos</option>
                                        <option value="available" {{ ($status ?? '') == 'available' ? 'selected' : '' }}>Disponibles</option>
                                        <option value="assigned" {{ ($status ?? '') == 'assigned' ? 'selected' : '' }}>Alquilados</option>
                                        <option value="maintenance" {{ ($status ?? '') == 'maintenance' ? 'selected' : '' }}>En Taller</option>
                                        <option value="out_of_service" {{ ($status ?? '') == 'out_of_service' ? 'selected' : '' }}>Fuera de Servicio</option>
                                    </select>
                                </div>

                                <div class="col-md-1 d-flex gap-1">
                                    <button type="submit" class="btn btn-primary btn-sm w-100 shadow-sm" title="Buscar / Filtrar">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    @if(!empty($start_datetime) || !empty($status))
                                        <a href="{{ route('vehiculos.index') }}" class="btn btn-light btn-sm border w-100" title="Limpiar filtros">
                                            <i class="bi bi-eraser"></i>
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                @if(!empty($start_datetime) && !empty($end_datetime))
                    <div class="alert alert-info shadow-sm d-flex align-items-center mb-4 border-info">
                        <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                        <div>
                            <strong>Modo Disponibilidad Activado:</strong> Estás viendo únicamente los vehículos libres desde el 
                            <strong>{{ \Carbon\Carbon::parse($start_datetime)->format('d/m/Y h:i A') }}</strong> hasta el 
                            <strong>{{ \Carbon\Carbon::parse($end_datetime)->format('d/m/Y h:i A') }}</strong>.
                        </div>
                    </div>
                @endif

                <div class="row g-4">
                    @forelse($vehiculos ?? [] as $vehiculo)
                        @php
                            $statusVehiculo = $vehiculo['status'] ?? '';

                            $badgeClass = match($statusVehiculo) {
                                'available' => 'bg-success',
                                'assigned' => 'bg-primary',
                                'maintenance' => 'bg-warning text-dark',
                                default => 'bg-secondary',
                            };

                            $statusLabel = match($statusVehiculo) {
                                'available' => 'Disponible',
                                'assigned' => 'Alquilado',
                                'maintenance' => 'En Taller',
                                'out_of_service' => 'De Baja',
                                default => 'Desconocido',
                            };

                            // Ajuste para la imagen
                            $apiHost = config('services.academy_api.url', 'http://127.0.0.1:8000');
                            if (!empty($vehiculo['image'])) {
                                $cleanPath = str_replace('public/', '', $vehiculo['image']);
                                $imagePath = rtrim($apiHost, '/') . '/storage/' . $cleanPath;
                            } else {
                                $imagePath = 'https://placehold.co/700x450/e2e8f0/475569?text=Sin+Imagen';
                            }
                        @endphp

                        <div class="col-sm-6 col-xl-4">
                            <div class="card h-100 shadow-sm border-0 position-relative">
                                
                                <div class="position-absolute top-0 end-0 m-2 z-1">
                                    <span class="badge {{ $badgeClass }} shadow-sm fs-6 px-3 py-2 rounded-pill">
                                        {{ $statusLabel }}
                                    </span>
                                </div>

                                <img src="{{ $imagePath }}"
                                     class="card-img-top"
                                     style="height: 220px; object-fit: cover;"
                                     onerror="this.src='https://placehold.co/700x450/e2e8f0/475569?text=Error+al+cargar'">

                                <div class="card-body">
                                    <div class="mb-3">
                                        <h5 class="fw-bold mb-0 text-dark">{{ $vehiculo['brand'] ?? 'Sin marca' }}</h5>
                                        <div class="text-muted fs-6">{{ $vehiculo['model'] ?? 'Sin modelo' }}</div>
                                    </div>

                                    <div class="d-flex justify-content-between text-muted small bg-light p-2 rounded border">
                                        <div><i class="bi bi-upc-scan me-1"></i> <strong>Placa:</strong> {{ $vehiculo['plate'] ?? 'N/D' }}</div>
                                        <div><i class="bi bi-calendar me-1"></i> <strong>Año:</strong> {{ $vehiculo['year'] ?? 'N/D' }}</div>
                                    </div>
                                </div>

                                <div class="card-footer bg-white border-top">
                                    <div class="d-flex justify-content-between flex-wrap gap-2">
                                        <a href="{{ route('vehiculos.show', $vehiculo['id']) }}"
                                           class="btn btn-outline-secondary btn-sm" title="Ver Detalle">
                                            <i class="bi bi-eye"></i> Detalle
                                        </a>

                                        <div class="d-flex gap-1">
                                            @can('update', [\App\Models\Vehicle::class, $vehiculo])
                                                <a href="{{ route('vehiculos.edit', $vehiculo['id']) }}"
                                                   class="btn btn-outline-primary btn-sm" title="Editar Vehículo">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            @endcan

                                            {{-- ========================================== --}}
                                            {{-- BLOQUEO ESTRICTO SI ESTÁ EN MANTENIMIENTO  --}}
                                            {{-- ========================================== --}}

                                            {{-- ASIGNAR (OPERADOR/ADMIN) --}}
                                            @can('update', [\App\Models\VehicleRequest::class, $vehiculo])
                                                @if($statusVehiculo == 'maintenance')
                                                    <button class="btn btn-secondary btn-sm" title="No se puede asignar: Vehículo en taller" disabled>
                                                        <i class="bi bi-person-x"></i>
                                                    </button>
                                                @else
                                                    <a href="{{ route('solicitudes.create', ['vehiculo' => $vehiculo['id'], 'accion' => 'asignar']) }}"
                                                       class="btn btn-success btn-sm" title="Asignar Ruta (Admin/Operador)">
                                                        <i class="bi bi-person-check"></i>
                                                    </a>
                                                @endif
                                            @endcan
                                            
                                            {{-- SOLICITAR (CHOFER) --}}
                                            @can('create', \App\Models\VehicleRequest::class)
                                                @if($statusVehiculo == 'maintenance')
                                                    <button class="btn btn-secondary btn-sm" title="No se puede solicitar: Vehículo en taller" disabled>
                                                        <i class="bi bi-send-x"></i>
                                                    </button>
                                                @else
                                                    <a href="{{ route('solicitudes.create', ['vehiculo' => $vehiculo['id'], 'accion' => 'solicitar']) }}"
                                                       class="btn btn-success btn-sm" title="Solicitar Vehículo (Chofer)">
                                                        <i class="bi bi-send-check"></i>
                                                    </a>
                                                @endif
                                            @endcan

                                            {{-- ENVIAR A MANTENIMIENTO (ADMIN/OPERADOR) --}}
                                            @can('create', \App\Models\Maintenance::class)
                                                @if($statusVehiculo == 'maintenance')
                                                    <button class="btn btn-secondary btn-sm" title="El vehículo ya está en mantenimiento" disabled>
                                                        <i class="bi bi-tools"></i>
                                                    </button>
                                                @else
                                                    <a href="{{ route('mantenimientos.create', ['vehicle_id' => $vehiculo['id']]) }}"
                                                       class="btn btn-warning btn-sm" title="Enviar a Mantenimiento">
                                                        <i class="bi bi-tools"></i>
                                                    </a>
                                                @endif
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted py-5 bg-white rounded shadow-sm">
                            <i class="bi bi-car-front display-4 text-secondary opacity-50"></i>
                            <h5 class="mt-3 fw-light">No se encontraron vehículos.</h5>
                            <p>Intenta ajustar los filtros de búsqueda.</p>
                            @if(!empty($status) || !empty($start_datetime))
                                <a href="{{ route('vehiculos.index') }}" class="btn btn-outline-secondary mt-2">
                                    <i class="bi bi-eraser"></i> Limpiar Filtros
                                </a>
                            @endif
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

    </main>

    @include('layouts.footer')

</div>

<script src="{{ asset('js/adminlte.js') }}"></script>
</body>
</html>