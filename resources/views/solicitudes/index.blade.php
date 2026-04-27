<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>RentaCar | Solicitudes</title>
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
                            <h3 class="mb-0">Gestión de Solicitudes</h3>
                        </div>
                        <div class="col-sm-6 text-end">
                            <a href="{{ route('vehiculos.index') }}" class="btn btn-primary shadow-sm">
                                <i class="bi bi-plus-circle"></i> Nueva Solicitud
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">

                    {{-- ALERTAS --}}
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

                    <div class="card card-info card-outline shadow-sm">
                        <div class="card-header border-0">
                            <h5 class="mb-0 text-dark fw-bold">Historial de Peticiones</h5>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Chofer / Solicitante</th>
                                            <th>Vehículo Solicitado</th>
                                            <th>Periodo de Uso</th>
                                            <th class="text-center">Estado Solicitud</th>
                                            <th class="text-center" style="width: 200px;">Acciones / Viaje</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($solicitudes as $solicitud)
                                            @php
                                                $reqStatus = strtolower($solicitud['status']);
                                                // Verificamos si la API incluyó el viaje asociado
                                                $hasTrip = isset($solicitud['trip']) && !empty($solicitud['trip']);
                                                $tripStatus = $hasTrip ? strtolower($solicitud['trip']['status']) : null;
                                                $tripId = $hasTrip ? $solicitud['trip']['id'] : null;
                                            @endphp
                                            <tr>
                                                <td class="fw-medium">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-secondary bg-opacity-10 p-2 rounded-circle me-2">
                                                            <i class="bi bi-person text-secondary"></i>
                                                        </div>
                                                        {{ $solicitud['user']['name'] ?? 'Usuario N/A' }}
                                                    </div>
                                                </td>

                                                <td>
                                                    <span class="fw-bold text-dark">{{ $solicitud['vehicle']['plate'] ?? 'S/P' }}</span><br>
                                                    <small class="text-muted text-uppercase small">{{ $solicitud['vehicle']['brand'] ?? '' }} {{ $solicitud['vehicle']['model'] ?? '' }}</small>
                                                </td>

                                                <td class="small">
                                                    <div class="text-success fw-medium"><i class="bi bi-clock-history me-1"></i> {{ \Carbon\Carbon::parse($solicitud['start_datetime'])->format('d/m/Y H:i') }}</div>
                                                    <div class="text-muted fst-italic"><i class="bi bi-arrow-right me-1"></i> {{ \Carbon\Carbon::parse($solicitud['end_datetime'])->format('d/m/Y H:i') }}</div>
                                                </td>

                                                <td class="text-center">
                                                    @php
                                                        // Estado de la Solicitud
                                                        $badgeClass = match($reqStatus) {
                                                            'approved' => 'bg-success',
                                                            'rejected' => 'bg-danger',
                                                            'canceled', 'cancelled' => 'bg-secondary',
                                                            'pending'  => 'bg-warning text-dark',
                                                            default    => 'bg-light text-dark'
                                                        };
                                                        $statusTr = match($reqStatus) {
                                                            'approved' => 'Aprobada',
                                                            'rejected' => 'Rechazada',
                                                            'canceled', 'cancelled' => 'Cancelada',
                                                            'pending'  => 'Pendiente',
                                                            default    => ucfirst($reqStatus)
                                                        };
                                                    @endphp
                                                    <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill shadow-sm mb-1 d-inline-block">
                                                        {{ $statusTr }}
                                                    </span>

                                                    {{-- Muestra una pequeña etiqueta extra si el viaje ya está en progreso o finalizó --}}
                                                    @if($hasTrip)
                                                        <br>
                                                        @if($tripStatus === 'in_progress')
                                                            <span class="badge bg-info text-dark small" style="font-size: 0.7rem;"><i class="bi bi-car-front-fill"></i> En Ruta</span>
                                                        @elseif($tripStatus === 'finished')
                                                            <span class="badge bg-dark small" style="font-size: 0.7rem;"><i class="bi bi-check2-circle"></i> Viaje Finalizado</span>
                                                        @endif
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        
                                                        {{-- 🔵 ACCIONES PARA ADMIN (1) Y OPERADOR (2) --}}
                                                        @if(in_array(auth()->user()->role_id, [1, 2]))
                                                            
                                                            {{-- APROBAR / RECHAZAR --}}
                                                            @if($reqStatus == 'pending')
                                                                <form action="{{ route('solicitudes.approve', $solicitud['id']) }}" method="POST" class="d-inline">
                                                                    @csrf @method('PATCH')
                                                                    <button class="btn btn-sm btn-success" title="Aprobar">
                                                                        <i class="bi bi-check-circle"></i>
                                                                    </button>
                                                                </form>

                                                                <form action="{{ route('solicitudes.reject', $solicitud['id']) }}" method="POST" class="d-inline">
                                                                    @csrf @method('PATCH')
                                                                    <button class="btn btn-sm btn-danger" title="Rechazar">
                                                                        <i class="bi bi-x-circle"></i>
                                                                    </button>
                                                                </form>
                                                            @endif

                                                            {{-- LÓGICA DEL VIAJE --}}
                                                            @if($reqStatus == 'approved')
                                                                @if(!$hasTrip)
                                                                    {{-- No hay viaje creado -> Mostrar botón INICIAR --}}
                                                                    <a href="{{ route('viajes.create', ['request_id' => $solicitud['id']]) }}" 
                                                                       class="btn btn-sm btn-primary px-3" title="Registrar Salida">
                                                                        <i class="bi bi-play-fill me-1"></i> Iniciar
                                                                    </a>
                                                                @elseif($tripStatus === 'in_progress')
                                                                    {{-- Ya hay viaje y está en progreso -> Mostrar botón DEVOLVER --}}
                                                                    <a href="{{ route('viajes.edit', $tripId) }}" 
                                                                       class="btn btn-sm btn-warning px-3 fw-bold" title="Registrar Devolución">
                                                                        <i class="bi bi-arrow-return-left me-1"></i> Devolver
                                                                    </a>
                                                                @endif
                                                                {{-- Si el viaje está 'finished', no mostramos ningún botón de acción --}}
                                                            @endif

                                                        @endif

                                                        {{-- 🟢 ACCIONES PARA EL CHOFER (3) --}}
                                                        @if(auth()->user()->role_id == 3 && in_array($reqStatus, ['pending', 'approved']))
                                                            @if(auth()->id() == $solicitud['user_id'] && !$hasTrip)
                                                                <form action="{{ route('solicitudes.cancel', $solicitud['id']) }}" method="POST" class="d-inline" 
                                                                      onsubmit="return confirm('¿Confirmas que deseas cancelar tu solicitud?')">
                                                                    @csrf @method('PATCH')
                                                                    <button class="btn btn-sm btn-outline-danger" title="Cancelar mi solicitud">
                                                                        <i class="bi bi-trash3 me-1"></i> Cancelar
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        @endif

                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-5 text-muted fst-italic">
                                                    <i class="bi bi-clipboard-x fs-1 d-block mb-2 opacity-50"></i>
                                                    No se encontraron registros de solicitudes.
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