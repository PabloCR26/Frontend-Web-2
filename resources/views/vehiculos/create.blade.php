<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>RentaCar | Registrar Vehiculo</title>
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
                        <h3 class="mb-0">Registrar Vehiculo</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>Errores:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @can('create', \App\Models\Vehicle::class)
                    <div class="row justify-content-center">
                        <div class="col-lg-10">

                            <div class="card shadow-sm">
                                <div class="card-header">Nuevo Vehiculo</div>

                                <div class="card-body">

                                    <form action="{{ route('vehiculos.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Placa</label>
                                                <input type="text" name="plate" class="form-control" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Marca</label>
                                                <input type="text" name="brand" class="form-control" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Modelo</label>
                                                <input type="text" name="model" class="form-control" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Año</label>
                                                <input type="number" name="year" class="form-control" required>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">Tipo</label>
                                                <select name="type" class="form-select" required>
                                                    <option value="sedan">Sedan</option>
                                                    <option value="pickup">Pick-up</option>
                                                    <option value="suv">SUV</option>
                                                    <option value="moto">Moto</option>
                                                    <option value="van">Van</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">Capacidad</label>
                                                <input type="number" name="capacity" class="form-control" required>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">Combustible</label>
                                                <select name="fuel_type" class="form-select" required>
                                                    <option value="gasolina">Gasolina</option>
                                                    <option value="diesel">Diesel</option>
                                                    <option value="hibrido">Hibrido</option>
                                                    <option value="electrico">Electrico</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Estado</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="available">Disponible</option>
                                                    <option value="assigned">Alquilado</option>
                                                    <option value="maintenance">Mantenimiento</option>
                                                </select>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label class="form-label fw-bold">Imagen</label>
                                                <input type="file" name="image" class="form-control" accept="image/*">
                                            </div>

                                        </div>

                                        <hr>

                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="bi bi-save"></i> Registrar
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
                @endcan

            </div>
        </div>

    </main>

    @include('layouts.footer')

</div>

<script src="{{ asset('js/adminlte.js') }}"></script>

</body>
</html>