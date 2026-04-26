<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>RentaCar | Registrar Viaje</title>
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
                            <h3 class="mb-0">Registrar salida de vehículo</h3>
                        </div>

                        <div class="col-sm-6 text-end">
                            <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary">
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
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <!-- CARD -->
                    <div class="card shadow-sm">
                        <div class="card-header">Datos del viaje</div>

                        <div class="card-body">

                            <form action="{{ route('viajes.store') }}" method="POST">
                                @csrf

                                <!-- 🔥 DATOS OCULTOS -->
                                <input type="hidden" name="vehicle_id" value="{{ $solicitud['vehicle_id'] }}">
                                <input type="hidden" name="user_id" value="{{ $solicitud['user_id'] }}">

                                <!-- VEHICULO -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Vehículo</label>
                                    <input type="text" class="form-control"
                                        value="{{ $solicitud['vehicle']['brand'] }} {{ $solicitud['vehicle']['model'] }} - {{ $solicitud['vehicle']['plate'] }}"
                                        readonly>
                                </div>

                                <!-- CHOFER -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Chofer</label>
                                    <input type="text" class="form-control"
                                        value="{{ $solicitud['user']['name'] }}"
                                        readonly>
                                </div>

                                <!-- RUTA -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Ruta</label>
                                    <select name="route_id" class="form-select" required>
                                        <option value="">Seleccione una ruta</option>

                                        @foreach($rutas as $ruta)
                                        <option value="{{ $ruta['id'] }}">
                                            {{ $ruta['name'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="departure_datetime" value="{{ now()->format('Y-m-d H:i:s') }}">
                                <!-- KM SALIDA -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Kilometraje de salida</label>
                                    <input type="number" name="km_departure" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Observaciones</label>
                                    <textarea name="observation" class="form-control" rows="3"></textarea>
                                </div>
                                <hr>

                                <!-- BOTONES -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bi bi-car-front"></i> Iniciar viaje
                                    </button>

                                    <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary">
                                        Cancelar
                                    </a>
                                </div>

                            </form>

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