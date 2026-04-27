<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>RentaCar | Control de Viajes</title>
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
                            <h3 class="mb-0">Viajes Activos / Bitácora</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card card-primary card-outline shadow-sm border-0">
                        <div class="card-header border-0 bg-white">
                            <h5 class="mb-0 text-dark fw-bold">Bitácora de Viajes</h5>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Vehículo</th>
                                            <th>Chofer / Ruta</th>
                                            <th>Detalle de Tiempos y KM</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($viajes as $viaje)
                                            @php
                                                $status = $viaje['status'] ?? 'in_progress';
                                            @endphp
                                            <tr>
                                                <td class="fw-bold text-muted">#{{ $viaje['id'] }}</td>
                                                
                                                <td>
                                                    <span class="fw-bold text-dark">{{ $viaje['vehiculo_placa'] ?? 'N/D' }}</span><br>
                                                </td>

                                                <td>
                                                    <div class="fw-medium text-dark"><i class="bi bi-person-circle text-secondary me-1"></i> {{ $viaje['chofer'] ?? 'N/D' }}</div>
                                                    {{-- Si la API manda el nombre de la ruta, lo mostramos. Si no, solo dejamos el chofer --}}
                                                    <div class="small text-muted mt-1"><i class="bi bi-geo-alt-fill text-danger opacity-75 me-1"></i> {{ $viaje['ruta_nombre'] ?? 'N/D' }}</div>
                                                </td>

                                                <td class="small">
                                                    {{-- DATOS DE SALIDA --}}
                                                    <div class="mb-1">
                                                        <span class="text-primary fw-bold"><i class="bi bi-box-arrow-up-right me-1"></i> Salida:</span><br>
                                                        <span class="text-muted">{{ \Carbon\Carbon::parse($viaje['departure_datetime'])->format('d/m/Y H:i') }} | <strong>{{ $viaje['km_departure'] }} km</strong></span>
                                                    </div>

                                                    {{-- DATOS DE REGRESO (Solo si ya finalizó) --}}
                                                    @if($status == 'finished' && !empty($viaje['return_datetime']))
                                                        <div class="mt-2 border-top pt-1">
                                                            <span class="text-success fw-bold"><i class="bi bi-box-arrow-in-down-right me-1"></i> Llegada:</span><br>
                                                            <span class="text-muted">{{ \Carbon\Carbon::parse($viaje['return_datetime'])->format('d/m/Y H:i') }} | <strong>{{ $viaje['km_return'] ?? 'N/D' }} km</strong></span>
                                                        </div>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if($status == 'in_progress')
                                                        <span class="badge bg-info text-dark px-3 py-2 rounded-pill"><i class="bi bi-car-front-fill me-1"></i> En Ruta</span>
                                                    @else
                                                        <span class="badge bg-dark px-3 py-2 rounded-pill"><i class="bi bi-check2-circle me-1"></i> Finalizado</span>
                                                    @endif

                                                    @if(!empty($viaje['observations']))
                                                        <i class="bi bi-chat-text-fill text-muted ms-1" title="Tiene observaciones"></i>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if($status == 'in_progress')
                                                        <a href="{{ route('viajes.edit', $viaje['id']) }}" class="btn btn-warning btn-sm fw-bold shadow-sm">
                                                            <i class="bi bi-arrow-return-left me-1"></i> Devolver
                                                        </a>
                                                    @else
                                                        <button class="btn btn-light border btn-sm text-muted" disabled>
                                                            <i class="bi bi-lock-fill me-1"></i> Cerrado
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-5 text-muted fst-italic">
                                                    <i class="bi bi-sign-stop fs-1 d-block mb-2 opacity-50"></i>
                                                    No hay viajes registrados en el sistema.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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