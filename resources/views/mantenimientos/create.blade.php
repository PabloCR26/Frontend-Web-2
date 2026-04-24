<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>RentaCar | Registrar Mantenimiento</title>
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
                            <h3 class="mb-0">Registrar Mantenimiento</h3>
                        </div>
                        <div class="col-sm-6 text-end">
                            <a href="{{ route('mantenimientos.index') }}" class="btn btn-secondary shadow-sm">
                                <i class="bi bi-arrow-left"></i> Volver al listado
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    @can('create', \App\Models\Maintenance::class)
                        <div class="row justify-content-center">
                            <div class="col-lg-8">

                                {{-- ERRORES CON ESTILO UNIFICADO --}}
                                @if(session('error') || $errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                        <strong><i class="bi bi-exclamation-triangle-fill"></i> ¡Atención!</strong>
                                        Por favor, revisa lo siguiente:
                                        <ul class="mb-0 mt-2">
                                            @if(session('error')) 
                                                <li>{{ session('error') }}</li> 
                                            @endif
                                            @foreach ($errors->all() as $error) 
                                                <li>{{ $error }}</li> 
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <div class="card card-info card-outline shadow-sm border-0">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0 fw-bold">Apertura de Orden de Trabajo</h5>
                                    </div>
                                    
                                    <div class="card-body p-4">

                                        <form action="{{ route('mantenimientos.store') }}" method="POST">
                                            @csrf

                                            <div class="row g-3">

                                                <div class="col-md-12">
                                                    <label class="form-label fw-bold">Vehículo <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-car-front"></i></span>
                                                        <select name="vehicle_id" class="form-select" required>
                                                            <option value="">Seleccione un vehículo de la flota...</option>
                                                            @foreach($vehiculos as $v)
                                                                @if($v['status'] !== 'out_of_service')
                                                                    <option value="{{ $v['id'] }}" 
                                                                        {{ old('vehicle_id', request('vehicle_id')) == $v['id'] ? 'selected' : '' }}
                                                                        {{ $v['status'] === 'maintenance' ? 'disabled' : '' }}>
                                                                        
                                                                        {{ $v['plate'] }} - {{ $v['brand'] }} {{ $v['model'] }}
                                                                        
                                                                        @if($v['status'] === 'maintenance')
                                                                            (Actualmente en taller)
                                                                        @endif
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-text text-muted">Los vehículos fuera de servicio o que ya están en el taller no pueden ser seleccionados.</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Tipo de mantenimiento <span class="text-danger">*</span></label>
                                                    <select name="type" class="form-select" required>
                                                        <option value="">Seleccione...</option>
                                                        <option value="preventive" {{ old('type') === 'preventive' ? 'selected' : '' }}>Preventivo (Cambio de aceite, revisión, etc.)</option>
                                                        <option value="corrective" {{ old('type') === 'corrective' ? 'selected' : '' }}>Correctivo (Reparación de daños, fallas)</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Fecha de inicio <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                                        <input type="date" name="start_date" class="form-control"
                                                            value="{{ old('start_date', date('Y-m-d')) }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label fw-bold">Costo Estimado <span class="text-muted fw-normal">(Opcional)</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text fw-bold">$</span>
                                                        <input type="number" step="0.01" min="0" name="cost"
                                                            class="form-control fs-5" value="{{ old('cost') }}" placeholder="0.00">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label fw-bold">Descripción del Trabajo <span class="text-danger">*</span></label>
                                                    <textarea name="description" class="form-control" rows="4" required
                                                        placeholder="Detalle el motivo del ingreso al taller, piezas a cambiar o fallas reportadas...">{{ old('description') }}</textarea>
                                                </div>

                                            </div>

                                            <div class="alert alert-info mt-4 shadow-sm border-info d-flex align-items-center">
                                                <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                                                <div>
                                                    <strong>Nota importante:</strong> Al guardar este registro, el estado del vehículo cambiará automáticamente a "Mantenimiento" y no podrá ser asignado a nuevos viajes.
                                                </div>
                                            </div>

                                            <hr class="mt-4">

                                            <div class="d-flex gap-2 justify-content-end">
                                                <a href="{{ route('mantenimientos.index') }}" class="btn btn-secondary px-4">Cancelar</a>
                                                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                                    <i class="bi bi-tools"></i> Guardar Mantenimiento
                                                </button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger shadow-sm">
                            <i class="bi bi-shield-lock-fill me-2"></i> No tienes permiso para registrar mantenimientos en el sistema.
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