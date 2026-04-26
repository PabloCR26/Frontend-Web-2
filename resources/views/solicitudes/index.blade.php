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

        <!-- HEADER -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Solicitudes</h3>
                    </div>

                    <div class="col-sm-6 text-end">
                        <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="app-content">
            <div class="container-fluid">

                <!-- MENSAJES -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- TABLA -->
                <div class="card shadow-sm">
                    <div class="card-header">Listado de Solicitudes</div>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Chofer</th>
                                        <th>Vehículo</th>
                                        <th>Inicio</th>
                                        <th>Fin</th>
                                        <th>Estado</th>
                                        <th width="220">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($solicitudes as $solicitud)
                                        <tr>

                                            <!-- CHOFER -->
                                            <td>{{ $solicitud['user']['name'] ?? 'N/A' }}</td>

                                            <!-- VEHICULO -->
                                            <td>
                                                {{ $solicitud['vehicle']['brand'] ?? '' }}
                                                {{ $solicitud['vehicle']['model'] ?? '' }}
                                            </td>

                                            <!-- FECHAS -->
                                            <td>{{ $solicitud['start_datetime'] }}</td>
                                            <td>{{ $solicitud['end_datetime'] }}</td>

                                            <!-- ESTADO -->
                                            <td>
                                                <span class="badge bg-{
                                                    { $solicitud['status'] == 'approved' ? 'success' :
                                                    ($solicitud['status'] == 'rejected' ? 'danger' :
                                                    ($solicitud['status'] == 'canceled' ? 'secondary' : 'warning')) }}">
                                                    {{ ucfirst($solicitud['status']) }}
                                                </span>
                                            </td>

                                            <!-- ACCIONES -->
                                            <td>

                                                {{-- 🔵 OPERADOR --}}
                                                @if(auth()->user()->role_id != 3)

                                                    @if($solicitud['status'] == 'pending')
                                                        <form action="{{ route('solicitudes.approve', $solicitud['id']) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button class="btn btn-success btn-sm">
                                                                <i class="bi bi-check"></i>
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('solicitudes.reject', $solicitud['id']) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button class="btn btn-danger btn-sm">
                                                                <i class="bi bi-x"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if($solicitud['status'] == 'approved')
                                                        <a href="{{ route('viajes.create', ['request_id' => $solicitud['id']]) }}"
                                                           class="btn btn-primary btn-sm">
                                                            <i class="bi bi-car-front"></i>
                                                        </a>
                                                    @endif

                                                @endif

                                                {{-- 🟢 CHOFER --}}
                                                @if(auth()->id() == $solicitud['user_id'] && $solicitud['status'] == 'pending')
                                                    <form action="{{ route('solicitudes.index', $solicitud['id']) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-secondary btn-sm">
                                                            <i class="bi bi-x-circle"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No hay solicitudes disponibles</td>
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