<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>RentaCar | Solicitud de Vehículo</title>

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
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">
                                @if($accion === 'asignar')
                                Asignar Vehículo
                                @else
                                Solicitar Vehículo
                                @endif
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="app-content">
                <div class="container-fluid">

                    @can('create', \App\Models\VehicleRequest::class)
                    <div class="row justify-content-center">
                        <div class="col-md-9">

                            {{-- ALERTA ERRORES --}}
                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><i class="bi bi-exclamation-triangle-fill"></i> ¡Atención!</strong>
                                Revisa los siguientes errores:
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            <div class="card shadow-sm">

                                <div class="card-header">
                                    Datos de la Solicitud
                                </div>

                                <div class="card-body">

                                    {{-- INFO VEHÍCULO --}}
                                    @if($vehiculo)
                                    <div class="alert alert-info">
                                        <i class="bi bi-car-front-fill"></i>
                                        <strong>Vehículo seleccionado:</strong>
                                        {{ $vehiculo['brand'] }} {{ $vehiculo['model'] }}
                                    </div>
                                    @endif

                                    <form action="{{ route('solicitudes.store') }}" method="POST" id="formSolicitud">

                                        @csrf

                                        <input type="hidden" name="vehicle_id" value="{{ $vehiculo['id'] ?? '' }}">

                                        <div class="row">

                                            <!-- FECHA INICIO -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Fecha inicio</label>
                                                <input type="datetime-local" name="start_datetime" class="form-control" required>
                                            </div>

                                            <!-- FECHA FIN -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Fecha fin</label>
                                                <input type="datetime-local" name="end_datetime" class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
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
                                            <!-- OBSERVACIÓN -->
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label fw-bold">Observación</label>
                                                <textarea name="observation" class="form-control" rows="3"
                                                    placeholder="Opcional..."></textarea>
                                            </div>

                                            <!-- STATUS (solo si es asignar) -->
                                            @if($accion === 'asignar')
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Estado</label>
                                                <select name="status" class="form-select">
                                                    <option value="approved">Aprobado</option>
                                                    <option value="assigned">Asignado</option>
                                                </select>
                                            </div>
                                            @else
                                            <input type="hidden" name="status" value="pending">
                                            @endif

                                        </div>

                                        <hr>

                                        <div class="d-flex justify-content-start gap-2">

                                            <button type="submit" class="btn btn-primary">
                                                @if($accion === 'asignar')
                                                <i class="bi bi-person-check"></i> Asignar Vehículo
                                                @else
                                                <i class="bi bi-send"></i> Enviar Solicitud
                                                @endif
                                            </button>

                                            <a href="{{ route('mantenimientos.index') }}" class="btn btn-secondary">
                                                Cancelar
                                            </a>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>
                    @else
                    <div class="alert alert-danger shadow-sm">
                        <i class="bi bi-shield-lock-fill"></i> No tienes permiso.
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