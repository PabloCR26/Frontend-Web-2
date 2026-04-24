<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>RentaCar | Registrar Mantenimiento</title>
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
                        <h3 class="mb-0">Registrar Mantenimiento</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                @can('create', \App\Models\Maintenance::class)
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row justify-content-center">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header">
                                    Registro de Mantenimiento
                                </div>
                                <div class="card-body">

                                    <form action="{{ route('mantenimientos.store') }}" method="POST">
                                        @csrf

                                        <div class="row">

                                            <div class="col-md-12 mb-3">
                                                <label>Vehiculo</label>
                                                <select name="vehicle_id" class="form-control" required>
                                                    <option value="">Seleccione un vehiculo</option>
                                                    @foreach($vehiculos as $v)
                                                        @if($v['status'] !== 'out_of_service')
                                                            <option value="{{ $v['id'] }}" {{ old('vehicle_id', request('vehicle_id')) == $v['id'] ? 'selected' : '' }}>
                                                                {{ $v['plate'] }} - {{ $v['brand'] }} {{ $v['model'] }}
                                                                @if($v['status'] === 'maintenance')
                                                                    (Ya en mantenimiento)
                                                                @endif
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <small class="text-muted">Los vehiculos fuera de servicio no estan disponibles.</small>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Tipo de mantenimiento</label>
                                                <select name="type" class="form-control" required>
                                                    <option value="">Seleccione</option>
                                                    <option value="preventive" {{ old('type') === 'preventive' ? 'selected' : '' }}>Preventivo</option>
                                                    <option value="corrective" {{ old('type') === 'corrective' ? 'selected' : '' }}>Correctivo</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Fecha de inicio</label>
                                                <input type="date" name="start_date" class="form-control"
                                                       value="{{ old('start_date', date('Y-m-d')) }}" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Costo estimado ($)</label>
                                                <input type="number" step="0.01" min="0" name="cost"
                                                       class="form-control" value="{{ old('cost') }}" required>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label>Descripcion</label>
                                                <textarea name="description" class="form-control" rows="3"
                                                          placeholder="Detalle del mantenimiento...">{{ old('description') }}</textarea>
                                            </div>

                                        </div>

                                        <button type="submit" class="btn btn-primary">Guardar Mantenimiento</button>
                                        <a href="{{ route('mantenimientos.index') }}" class="btn btn-secondary">Cancelar</a>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger">
                        No tienes permiso para registrar mantenimientos.
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
