<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>RentaCar | Crear Vehiculo</title>

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
                        <h3 class="mb-0">Crear Vehiculo</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                @can('create', \App\Models\Vehicle::class)
                    <div class="row justify-content-center">
                        <div class="col-md-9">

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong><i class="bi bi-exclamation-triangle-fill"></i> ¡Atención!</strong> 
                                    Revisa los siguientes errores:
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="card shadow-sm">

                                <div class="card-header">
                                    Registro de Vehiculo
                                </div>

                                <div class="card-body">

                                    <form action="{{ route('vehiculos.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Placa</label>
                                                <input type="text" name="plate" class="form-control" value="{{ old('plate') }}" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Marca</label>
                                                <input type="text" name="brand" class="form-control" value="{{ old('brand') }}" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Modelo</label>
                                                <input type="text" name="model" class="form-control" value="{{ old('model') }}" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Año</label>
                                                <input type="number" name="year" class="form-control" value="{{ old('year') }}" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Tipo de vehiculo</label>
                                                <select name="type" class="form-select" required>
                                                    <option value="">Seleccione</option>
                                                    <option value="sedan" {{ old('type') == 'sedan' ? 'selected' : '' }}>Sedan</option>
                                                    <option value="pickup" {{ old('type') == 'pickup' ? 'selected' : '' }}>Pick-up</option>
                                                    <option value="suv" {{ old('type') == 'suv' ? 'selected' : '' }}>SUV</option>
                                                    <option value="moto" {{ old('type') == 'moto' ? 'selected' : '' }}>Moto</option>
                                                    <option value="van" {{ old('type') == 'van' ? 'selected' : '' }}>Van</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Capacidad (personas)</label>
                                                <input type="number" name="capacity" class="form-control" value="{{ old('capacity') }}" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Tipo de combustible</label>
                                                <select name="fuel_type" class="form-select" required>
                                                    <option value="">Seleccione</option>
                                                    <option value="gasolina" {{ old('fuel_type') == 'gasolina' ? 'selected' : '' }}>Gasolina</option>
                                                    <option value="diesel" {{ old('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                                    <option value="hibrido" {{ old('fuel_type') == 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                                                    <option value="electrico" {{ old('fuel_type') == 'electrico' ? 'selected' : '' }}>Eléctrico</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Estado inicial</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Disponible</option>
                                                    <option value="assigned" {{ old('status') == 'assigned' ? 'selected' : '' }}>Alquilado</option>
                                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Mantenimiento</option>
                                                </select>
                                            </div>

                                            <div class="col-md-12 mb-4">
                                                <label class="form-label fw-bold">Imagen del vehiculo</label>
                                                <input type="file" name="image" class="form-control" accept="image/*" required>
                                                <div class="form-text">Formatos permitidos: JPG, PNG, JPEG. Máximo 2MB.</div>
                                            </div>

                                        </div>

                                        <hr>

                                        <div class="d-flex justify-content-start gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-cloud-arrow-up"></i> Guardar Vehiculo
                                            </button>

                                            <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">
                                                Cancelar
                                            </a>
                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>
                @else
                    <div class="alert alert-danger shadow-sm">
                        <i class="bi bi-shield-lock-fill"></i> No tienes permiso para registrar vehiculos.
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