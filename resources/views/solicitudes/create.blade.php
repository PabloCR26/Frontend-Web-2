<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>RentaCar | {{ $accion == 'asignar' ? 'Asignación Directa' : 'Nueva Solicitud' }}</title>
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
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">
                                {{ $accion == 'asignar' ? 'Asignación Directa de Vehículo' : 'Solicitar Vehículo' }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-8">

                            {{-- ALERTAS DE ERROR DE NEGOCIO (F.5 y F.6) --}}
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                                    <i class="bi bi-exclamation-octagon-fill me-2"></i>
                                    <strong>Error:</strong> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="card card-primary card-outline shadow-sm">
                                <form action="{{ route('solicitudes.store') }}" method="POST">
                                    @csrf
                                    {{-- Campo oculto para que el controlador sepa a qué endpoint ir --}}
                                    <input type="hidden" name="accion" value="{{ $accion }}">
                                    <input type="hidden" name="vehicle_id" value="{{ $vehiculo['id'] ?? '' }}">

                                    <div class="card-body">
                                        
                                        <div class="alert alert-light border d-flex align-items-center mb-4">
                                            <i class="bi bi-car-front-fill fs-2 text-primary me-3"></i>
                                            <div>
                                                <h5 class="mb-0 fw-bold">{{ $vehiculo['brand'] ?? '' }} {{ $vehiculo['model'] ?? 'Vehículo no seleccionado' }}</h5>
                                                <span class="text-muted small text-uppercase">Placa: {{ $vehiculo['plate'] ?? '---' }}</span>
                                            </div>
                                        </div>

                                        <div class="row g-3">
                                            
                                            @if($accion == 'asignar')
                                                <div class="col-md-12">
                                                    <label class="form-label fw-bold text-primary">Seleccionar Chofer Responsable</label>
                                                    <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                                        <option value="">-- Seleccione un chofer --</option>
                                                        @foreach($choferes as $chofer)
                                                            <option value="{{ $chofer['id'] }}" {{ old('user_id') == $chofer['id'] ? 'selected' : '' }}>
                                                                {{ $chofer['name'] }} ({{ $chofer['email'] }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                            @else
                                                {{-- Si es chofer, el user_id es el suyo propio (lo maneja la API o enviamos hidden) --}}
                                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                            @endif

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Fecha/Hora Salida</label>
                                                <input type="datetime-local" name="start_datetime" 
                                                       class="form-control @error('start_datetime') is-invalid @enderror" 
                                                       value="{{ old('start_datetime') }}" required>
                                                @error('start_datetime') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Fecha/Hora Regreso Estimada</label>
                                                <input type="datetime-local" name="end_datetime" 
                                                       class="form-control @error('end_datetime') is-invalid @enderror" 
                                                       value="{{ old('end_datetime') }}" required>
                                                @error('end_datetime') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label fw-bold">Observaciones / Motivo del viaje</label>
                                                <textarea name="observation" class="form-control @error('observation') is-invalid @enderror" 
                                                          rows="3" placeholder="Indique el propósito del uso del vehículo...">{{ old('observation') }}</textarea>
                                                @error('observation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer bg-white text-end py-3">
                                        <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary px-4">Cancelar</a>
                                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                            <i class="bi bi-send-check me-1"></i>
                                            {{ $accion == 'asignar' ? 'Confirmar Asignación' : 'Enviar Solicitud' }}
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="mt-3 small text-muted">
                                <i class="bi bi-info-circle me-1"></i> 
                                Nota: El sistema validará automáticamente si el vehículo tiene traslapes de horario o mantenimientos activos.
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