<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>RentaCar | Devolver Vehículo</title>
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
                            <h3 class="mb-0">Registrar Devolución</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            @if(session('error') || $errors->any())
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    {{ session('error') ?? $errors->first() ?? 'Revisa los datos ingresados.' }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="card card-warning card-outline shadow-sm border-0">
                                <div class="card-header bg-white border-bottom-0 pb-0">
                                    <h5 class="mb-0 fw-bold"><i class="bi bi-arrow-return-left text-warning me-2"></i> Finalizar Viaje #{{ $viaje['id'] ?? '' }}</h5>
                                </div>

                                <div class="card-body">
                                    <form action="{{ route('viajes.update', $viaje['id'] ?? 0) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="row g-3 mb-4 p-3 bg-light rounded border">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-muted small mb-0">Kilometraje de Salida</label>
                                                <div class="fs-5 fw-bold text-primary">{{ $viaje['km_departure'] ?? '0' }} km</div>
                                            </div>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label class="form-label fw-bold">Kilometraje Actual (Regreso)</label>
                                                <div class="input-group">
                                                    <input type="number" name="km_return" 
                                                           class="form-control form-control-lg" 
                                                           value="{{ old('km_return') }}" 
                                                           min="{{ $viaje['km_departure'] ?? 0 }}" required>
                                                    <span class="input-group-text bg-white">km</span>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label fw-bold">Observaciones Finales</label>
                                                <textarea name="observation" class="form-control" rows="3" placeholder="Indique novedades del vehículo...">{{ old('observation') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                                            <a href="{{ route('viajes.index') }}" class="btn btn-light border px-4">Cancelar</a>
                                            <button type="submit" class="btn btn-warning px-4 shadow-sm fw-bold">
                                                <i class="bi bi-check2-circle me-1"></i> Confirmar Devolución
                                            </button>
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