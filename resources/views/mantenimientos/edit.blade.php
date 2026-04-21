<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>RentaCar | Editar Mantenimiento</title>
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
                        <h3 class="mb-0">Editar Mantenimiento</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                @can('update', [\App\Models\Maintenance::class, $mantenimiento])
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row justify-content-center">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <span>Editar Mantenimiento</span>
                                    @if($mantenimiento['status'] === 'open')
                                        <span class="badge bg-danger">Abierto</span>
                                    @else
                                        <span class="badge bg-success">Cerrado</span>
                                    @endif
                                </div>
                                <div class="card-body">

                                    <div class="alert alert-light border mb-4">
                                        <i class="bi bi-truck"></i>
                                        <strong>Vehiculo:</strong>
                                        {{ $mantenimiento['vehicle_plate'] }} -
                                        {{ $mantenimiento['vehicle_brand'] }} {{ $mantenimiento['vehicle_model'] }}
                                    </div>

                                    <form action="{{ route('mantenimientos.update', $mantenimiento['id']) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <label>Tipo de mantenimiento</label>
                                                <select name="type" class="form-control" required>
                                                    <option value="preventive" {{ $mantenimiento['type'] === 'preventive' ? 'selected' : '' }}>Preventivo</option>
                                                    <option value="corrective" {{ $mantenimiento['type'] === 'corrective' ? 'selected' : '' }}>Correctivo</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Estado</label>
                                                <select name="status" class="form-control" required id="statusSelect">
                                                    <option value="open" {{ $mantenimiento['status'] === 'open' ? 'selected' : '' }}>Abierto</option>
                                                    <option value="closed" {{ $mantenimiento['status'] === 'closed' ? 'selected' : '' }}>Cerrado</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Fecha de inicio</label>
                                                <input type="date" class="form-control"
                                                       value="{{ \Carbon\Carbon::parse($mantenimiento['start_date'])->format('Y-m-d') }}"
                                                       disabled>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Fecha de cierre</label>
                                                <input type="date" name="end_date" class="form-control"
                                                       value="{{ $mantenimiento['end_date'] ? \Carbon\Carbon::parse($mantenimiento['end_date'])->format('Y-m-d') : date('Y-m-d') }}">
                                                <small class="text-muted">Se asigna automaticamente si se deja vacio.</small>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Costo ($)</label>
                                                <input type="number" step="0.01" min="0" name="cost"
                                                       class="form-control" value="{{ $mantenimiento['cost'] }}" required>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label>Descripcion</label>
                                                <textarea name="description" class="form-control" rows="3">{{ $mantenimiento['description'] }}</textarea>
                                            </div>

                                        </div>

                                        <div id="closeAlert" class="alert alert-warning d-none">
                                            <i class="bi bi-exclamation-triangle"></i>
                                            <strong>Atencion!</strong> Al cerrar este mantenimiento, el vehiculo volvera a estar disponible.
                                        </div>

                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        <a href="{{ route('mantenimientos.index') }}" class="btn btn-secondary">Cancelar</a>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger">
                        No tienes permiso para editar este mantenimiento.
                    </div>
                @endcan

            </div>
        </div>
    </main>

    @include('layouts.footer')
</div>
<script src="{{ asset('js/adminlte.js') }}"></script>
<script>
    const statusSelect = document.getElementById('statusSelect');
    const closeAlert   = document.getElementById('closeAlert');

    if (statusSelect && closeAlert) {
        statusSelect.addEventListener('change', function () {
            closeAlert.classList.toggle('d-none', this.value !== 'closed');
        });

        statusSelect.dispatchEvent(new Event('change'));
    }
</script>
</body>
</html>
