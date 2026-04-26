<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>RentaCar | Historial del Chofer</title>
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
                        <h3 class="mb-0">Reporte 3 — Historial del Chofer</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-funnel"></i> Seleccionar chofer
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('reports.driver-history') }}">
                            <div class="row">
                                <div class="col-md-10 mb-3">
                                    <label>Chofer</label>
                                    <select name="driver_id" class="form-control" required>
                                        <option value="">Seleccione un chofer</option>
                                        @foreach($choferes as $c)
                                            <option value="{{ $c['id'] }}"
                                                {{ request('driver_id') == $c['id'] ? 'selected' : '' }}>
                                                {{ $c['name'] }} — {{ $c['email'] }}
                                            </option>
                                        @endforeach
                                    </select>
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

                @if(request('driver_id'))
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-person-badge"></i>
                                Historial de solicitudes
                                @if(count($historial) > 0)
                                    — {{ $historial[0]['chofer'] }}
                                @endif
                            </span>
                            <span class="badge bg-primary">{{ count($historial) }} registros</span>
                        </div>
                        <div class="card-body p-0">
                            @if(count($historial) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Vehículo</th>
                                                <th>Fecha inicio</th>
                                                <th>Fecha fin</th>
                                                <th class="text-center">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($historial as $h)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <strong>{{ $h['vehiculo'] }}</strong><br>
                                                    <small class="text-muted">{{ $h['brand'] }}</small>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($h['start_datetime'])->format('d/m/Y H:i') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($h['end_datetime'])->format('d/m/Y H:i') }}</td>
                                                <td class="text-center">
                                                    @php
                                                        $estado = $h['estado_solicitud'];
                                                        $badge = match($estado) {
                                                            'approved' => 'bg-success',
                                                            'pending'  => 'bg-warning text-dark',
                                                            'rejected' => 'bg-danger',
                                                            'canceled' => 'bg-secondary',
                                                            default    => 'bg-light text-dark',
                                                        };
                                                        $label = match($estado) {
                                                            'approved' => 'Aprobada',
                                                            'pending'  => 'Pendiente',
                                                            'rejected' => 'Rechazada',
                                                            'canceled' => 'Cancelada',
                                                            default    => $estado,
                                                        };
                                                    @endphp
                                                    <span class="badge {{ $badge }}">{{ $label }}</span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center text-muted py-5">
                                    <i class="bi bi-person-x fs-1"></i>
                                    <p class="mt-2">Este chofer no tiene solicitudes registradas.</p>
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