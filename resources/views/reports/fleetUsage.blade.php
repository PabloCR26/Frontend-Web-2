<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>RentaCar | Uso de Flotilla</title>
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
                        <h3 class="mb-0">Reporte 2 — Uso de Flotilla por Periodo</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-funnel"></i> Filtrar por periodo
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('reports.fleet-usage') }}">
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label>Fecha inicio</label>
                                    <input type="date" name="period_start" class="form-control"
                                           value="{{ request('period_start') }}" required>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label>Fecha fin</label>
                                    <input type="date" name="period_end" class="form-control"
                                           value="{{ request('period_end') }}" required>
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

                @if(request('period_start'))
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Uso de flotilla</span>
                            <span class="badge bg-primary">{{ count($uso) }} vehículos</span>
                        </div>
                        <div class="card-body p-0">
                            @if(count($uso) > 0)
                                <div class="row text-center p-3 border-bottom">
                                    <div class="col-md-4">
                                        <div class="p-3 bg-light rounded">
                                            <h4>{{ count($uso) }}</h4>
                                            <small class="text-muted">Vehículos activos</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 bg-light rounded">
                                            <h4>{{ array_sum(array_column($uso, 'total_viajes')) }}</h4>
                                            <small class="text-muted">Total viajes</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 bg-light rounded">
                                            <h4>{{ number_format(array_sum(array_column($uso, 'total_km_recorridos')), 1) }} km</h4>
                                            <small class="text-muted">Total kilómetros</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Placa</th>
                                                <th>Vehículo</th>
                                                <th class="text-center">Total Viajes</th>
                                                <th class="text-center">Km Recorridos</th>
                                                <th class="text-center">Promedio Km/Viaje</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($uso as $u)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><strong>{{ $u['plate'] }}</strong></td>
                                                <td>{{ $u['brand'] }} {{ $u['model'] }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-info text-dark">{{ $u['total_viajes'] }}</span>
                                                </td>
                                                <td class="text-center">{{ number_format($u['total_km_recorridos'], 1) }} km</td>
                                                <td class="text-center">
                                                    {{ $u['total_viajes'] > 0
                                                        ? number_format($u['total_km_recorridos'] / $u['total_viajes'], 1)
                                                        : '0' }} km
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center text-muted py-5">
                                    <i class="bi bi-bar-chart fs-1"></i>
                                    <p class="mt-2">No hay viajes en el periodo seleccionado.</p>
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