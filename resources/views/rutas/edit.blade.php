<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>RentaCar | Editar Ruta</title>
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
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Editar Ruta <span class="text-muted fs-5">#{{ $ruta['id'] ?? '' }}</span></h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="{{ route('rutas.index') }}" class="btn btn-secondary shadow-sm">
                            <i class="bi bi-arrow-left"></i> Volver al listado
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                @can('update', [\App\Models\Route::class, $ruta])
                    <div class="row justify-content-center">
                        <div class="col-md-8">

                            @if(session('error') || $errors->any())
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <strong><i class="bi bi-exclamation-triangle-fill"></i> ¡Atención!</strong>
                                    <ul class="mb-0 mt-2">
                                        @if(session('error')) <li>{{ session('error') }}</li> @endif
                                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="card card-info card-outline shadow-sm border-0">
                                <div class="card-header">
                                    <h5 class="mb-0 fw-bold">Actualizar Datos de la Ruta</h5>
                                </div>
                                <div class="card-body p-4">

                                    <form action="{{ route('rutas.update', $ruta['id']) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="row g-4">
                                            <div class="col-md-12">
                                                <label class="form-label fw-bold">Nombre de la Ruta <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-signpost-2"></i></span>
                                                    <input type="text" name="name" class="form-control" 
                                                           value="{{ old('name', $ruta['name']) }}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Punto de Inicio <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-geo-alt text-success"></i></span>
                                                    <input type="text" name="start_point" class="form-control" 
                                                           value="{{ old('start_point', $ruta['start_point']) }}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Punto de Destino <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-geo-fill text-danger"></i></span>
                                                    <input type="text" name="end_point" class="form-control" 
                                                           value="{{ old('end_point', $ruta['end_point']) }}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label fw-bold">Descripción del propósito <span class="text-danger">*</span></label>
                                                <textarea name="description" class="form-control" rows="3" required>{{ old('description', $ruta['description']) }}</textarea>
                                            </div>
                                        </div>

                                        <hr class="mt-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('rutas.index') }}" class="btn btn-secondary px-4">Cancelar</a>
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
                        <i class="bi bi-shield-lock-fill me-2"></i> No tienes permiso para editar esta ruta.
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