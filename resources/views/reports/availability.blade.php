<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>RentaCar | Reporte Disponibilidad</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"/>
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
                    <div class="col-sm-6">
                        <h3 class="mb-0">Reporte 1 — Disponibilidad de Vehículos</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-funnel"></i> Filtrar por rango de fechas
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('reports.availability') }}">
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label>Fecha y hora inicio</label>
                                    <input type="datetime-local" name="start" class="form-control"
                                           value="{{ request('start') }}" required>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label>Fecha y hora fin</label>
                                    <input type="datetime-local" name="end" class="form-control"
                                           value="{{ request('end') }}" required>
                                </div>
                                <div class="col-md-2 mb-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-search"></i> Consultar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if($error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endif

                @if(request('start'))
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Vehículos disponibles</span>
                            <span class="badge bg-success">{{ count($vehiculos) }} encontrados</span>
                        </div>
                        <div class="card-body">
                            @if(count($vehiculos) > 0)
                                <div class="row">
                                    @foreach($vehiculos as $v)
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100 shadow-sm">
                                            @if(!empty($v['image']))
                                                <img src="{{ $v['image'] }}"
                                                     class="card-img-top"
                                                     style="height: 180px; object-fit: cover;"
                                                     alt="{{ $v['brand'] }} {{ $v['model'] }}"
                                                     onerror="this.src='https://via.placeholder.com/300x180?text=Sin+imagen'">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center"
                                                     style="height: 180px;">
                                                    <i class="bi bi-car-front fs-1 text-muted"></i>
                                                </div>
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $v['brand'] }} {{ $v['model'] }}</h5>
                                                <p class="card-text mb-1">
                                                    <i class="bi bi-credit-card me-1"></i>
                                                    <strong>Placa:</strong> {{ $v['plate'] }}
                                                </p>
                                                <p class="card-text mb-1">
                                                    <i class="bi bi-people me-1"></i>
                                                    <strong>Capacidad:</strong> {{ $v['capacity'] }} personas
                                                </p>
                                                <span class="badge bg-success mt-2">
                                                    <i class="bi bi-check-circle"></i> Disponible
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center text-muted py-5">
                                    <i class="bi bi-car-front fs-1"></i>
                                    <p class="mt-2">No hay vehículos disponibles para el rango seleccionado.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </main>

    @include('layouts.footer')
</div>
<script src="{{ asset('js/adminlte.js') }}"></script>
</body>
</html>