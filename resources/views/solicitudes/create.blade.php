<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>RentaCar | Solicitar Vehículo</title>
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
                        <h3 class="mb-0">Solicitar Vehículo</h3>
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

                <!-- ERRORES -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>Errores:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row justify-content-center">
                    <div class="col-lg-8">

                        <div class="card shadow-sm">
                            <div class="card-header">Nueva Solicitud</div>

                            <div class="card-body">

                                <form action="{{ route('solicitudes.store') }}" method="POST">
                                    @csrf

                                    <!-- VEHICULO -->
                                    <input type="hidden" name="vehicle_id" value="{{ $vehiculo['id'] }}">

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Vehículo</label>
                                        <input type="text" class="form-control"
                                               value="{{ $vehiculo['brand'] }} {{ $vehiculo['model'] }} - {{ $vehiculo['plate'] }}"
                                               readonly>
                                    </div>

                                    <!-- FECHA INICIO -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Fecha inicio</label>
                                        <input type="datetime-local" name="start_datetime" class="form-control" required>
                                    </div>

                                    <!-- FECHA FIN -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Fecha fin</label>
                                        <input type="datetime-local" name="end_datetime" class="form-control" required>
                                    </div>

                                    <!-- OBSERVACION -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Observación</label>
                                        <textarea name="observation" class="form-control"></textarea>
                                    </div>

                                    <hr>

                                    <!-- BOTONES -->
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-success px-4">
                                            <i class="bi bi-send"></i> Enviar solicitud
                                        </button>

                                        <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">
                                            Cancelar
                                        </a>
                                    </div>

                                </form>

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