<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>RentaCar | Editar Vehiculo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    @php
        $item = $vehiculo['data'] ?? $vehiculo;
    @endphp

    <div class="app-wrapper">

        @include('layouts.navbar')
        @include('layouts.sidebar')

        <main class="app-main">

            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Editar Vehiculo</h3>
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
                    @can('update', [\App\Models\Vehicle::class, $item])
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        Actualizacion de Vehiculo
                                    </div>

                                    <div class="card-body">
                                        <form action="{{ route('vehiculos.update', $item['id']) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Placa</label>
                                                    <input type="text" name="plate" class="form-control" value="{{ old('plate', $item['plate'] ?? '') }}" required>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Marca</label>
                                                    <input type="text" name="brand" class="form-control" value="{{ old('brand', $item['brand'] ?? '') }}" required>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Modelo</label>
                                                    <input type="text" name="model" class="form-control" value="{{ old('model', $item['model'] ?? '') }}" required>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Ano</label>
                                                    <input type="number" name="year" class="form-control" value="{{ old('year', $item['year'] ?? '') }}" required>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Tipo de vehiculo</label>
                                                    <select name="type" class="form-control" required>
                                                        <option value="">Seleccione</option>
                                                        <option value="sedan" {{ old('type', $item['type'] ?? '') === 'sedan' ? 'selected' : '' }}>Sedan</option>
                                                        <option value="pickup" {{ old('type', $item['type'] ?? '') === 'pickup' ? 'selected' : '' }}>Pick-up</option>
                                                        <option value="suv" {{ old('type', $item['type'] ?? '') === 'suv' ? 'selected' : '' }}>SUV</option>
                                                        <option value="moto" {{ old('type', $item['type'] ?? '') === 'moto' ? 'selected' : '' }}>Moto</option>
                                                        <option value="van" {{ old('type', $item['type'] ?? '') === 'van' ? 'selected' : '' }}>Van</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Capacidad (personas)</label>
                                                    <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $item['capacity'] ?? '') }}" required>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Tipo de combustible</label>
                                                    <select name="fuel_type" class="form-control" required>
                                                        <option value="">Seleccione</option>
                                                        <option value="gasolina" {{ old('fuel_type', $item['fuel_type'] ?? '') === 'gasolina' ? 'selected' : '' }}>Gasolina</option>
                                                        <option value="diesel" {{ old('fuel_type', $item['fuel_type'] ?? '') === 'diesel' ? 'selected' : '' }}>Diesel</option>
                                                        <option value="hibrido" {{ old('fuel_type', $item['fuel_type'] ?? '') === 'hibrido' ? 'selected' : '' }}>Hibrido</option>
                                                        <option value="electrico" {{ old('fuel_type', $item['fuel_type'] ?? '') === 'electrico' ? 'selected' : '' }}>Electrico</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Estado</label>
                                                    <select name="status" class="form-control" required>
                                                        <option value="available" {{ old('status', $item['status'] ?? '') === 'available' ? 'selected' : '' }}>Disponible</option>
                                                        <option value="assigned" {{ old('status', $item['status'] ?? '') === 'assigned' ? 'selected' : '' }}>Alquilado</option>
                                                        <option value="maintenance" {{ old('status', $item['status'] ?? '') === 'maintenance' ? 'selected' : '' }}>Mantenimiento</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Imagen del vehiculo (URL o ruta)</label>
                                                    <input type="text" name="image" class="form-control" value="{{ old('image', $item['image'] ?? '') }}" placeholder="https://... o /img/car.jpg">
                                                </div>
                                            </div>

                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-save"></i> Actualizar Vehiculo
                                                </button>
                                                <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">Cancelar</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger">
                            No tienes permiso para editar este vehiculo.
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
