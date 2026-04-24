<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>RentaCar | Editar Mantenimiento</title>
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
                            <h3 class="mb-0">Editar Mantenimiento <span class="text-muted fs-5">#{{ $mantenimiento['id'] ?? '' }}</span></h3>
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
                    @can('update', [\App\Models\Maintenance::class, $mantenimiento])
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
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 fw-bold">Actualizar Orden</h5>
                                        @if($mantenimiento['status'] === 'open')
                                            <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="bi bi-exclamation-circle me-1"></i> Abierto</span>
                                        @else
                                            <span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle me-1"></i> Cerrado</span>
                                        @endif
                                    </div>

                                    <div class="card-body p-4">

                                        <div class="alert alert-light border border-secondary-subtle shadow-sm mb-4 d-flex align-items-center">
                                            <div class="bg-secondary bg-opacity-10 p-3 rounded me-3">
                                                <i class="bi bi-car-front-fill fs-3 text-secondary"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-1 fw-bold text-dark">{{ $mantenimiento['plate'] ?? 'N/A' }}</h5>
                                                <span class="text-muted fs-6">{{ $mantenimiento['brand'] ?? '' }} {{ $mantenimiento['model'] ?? '' }}</span>
                                            </div>
                                        </div>

                                        <form action="{{ route('mantenimientos.update', $mantenimiento['id']) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            @if(!empty($mantenimiento['start_date']))
                                                <input type="hidden" name="start_date" value="{{ \Carbon\Carbon::parse($mantenimiento['start_date'])->format('Y-m-d') }}">
                                            @endif

                                            <div class="row g-3">

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Tipo de mantenimiento <span class="text-danger">*</span></label>
                                                    <select name="type" class="form-select" required>
                                                        <option value="preventive" {{ old('type', $mantenimiento['type']) === 'preventive' ? 'selected' : '' }}>Preventivo</option>
                                                        <option value="corrective" {{ old('type', $mantenimiento['type']) === 'corrective' ? 'selected' : '' }}>Correctivo</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Estado <span class="text-danger">*</span></label>
                                                    <select name="status" class="form-select" required id="statusSelect">
                                                        <option value="open" {{ old('status', $mantenimiento['status']) === 'open' ? 'selected' : '' }}>Abierto</option>
                                                        <option value="closed" {{ old('status', $mantenimiento['status']) === 'closed' ? 'selected' : '' }}>Cerrado</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold text-muted">Fecha de inicio</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                                        <input type="date" class="form-control text-muted"
                                                            value="{{ !empty($mantenimiento['start_date']) ? \Carbon\Carbon::parse($mantenimiento['start_date'])->format('Y-m-d') : '' }}"
                                                            disabled>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Fecha de cierre</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                                        <input type="date" name="end_date" class="form-control"
                                                            value="{{ old('end_date', !empty($mantenimiento['end_date']) ? \Carbon\Carbon::parse($mantenimiento['end_date'])->format('Y-m-d') : date('Y-m-d')) }}">
                                                    </div>
                                                    <div class="form-text">Se asigna automáticamente a la fecha de hoy si se deja vacío.</div>
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label fw-bold">Costo Reportado <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text fw-bold">$</span>
                                                        <input type="number" step="0.01" min="0" name="cost"
                                                            class="form-control fs-5" value="{{ old('cost', $mantenimiento['cost']) }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label fw-bold">Descripción del Trabajo <span class="text-danger">*</span></label>
                                                    <textarea name="description" class="form-control" rows="4" required placeholder="Detalla los trabajos realizados o el motivo del mantenimiento...">{{ old('description', $mantenimiento['description']) }}</textarea>
                                                </div>

                                            </div>

                                            <div id="closeAlert" class="alert alert-warning mt-4 shadow-sm border-warning d-none d-flex align-items-center">
                                                <i class="bi bi-unlock-fill fs-4 me-3"></i>
                                                <div>
                                                    <strong>¡Atención!</strong> Al marcar la orden como "Cerrada", el vehículo se liberará y volverá a estar disponible para asignaciones.
                                                </div>
                                            </div>

                                            <hr class="mt-4">

                                            <div class="d-flex gap-2 justify-content-end">
                                                <a href="{{ route('mantenimientos.index') }}" class="btn btn-secondary px-4">Cancelar</a>
                                                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                                    <i class="bi bi-save"></i> Guardar Cambios
                                                </button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger shadow-sm">
                            <i class="bi bi-shield-lock-fill me-2"></i> No tienes permiso para editar este mantenimiento.
                        </div>
                    @endcan

                </div>
            </div>
        </main>

        @include('layouts.footer')
    </div>
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('statusSelect');
            const closeAlert   = document.getElementById('closeAlert');

            if (statusSelect && closeAlert) {
                statusSelect.addEventListener('change', function () {
                    if (this.value === 'closed') {
                        closeAlert.classList.remove('d-none');
                    } else {
                        closeAlert.classList.add('d-none');
                    }
                });

                statusSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
</body>

</html>