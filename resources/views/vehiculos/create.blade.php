<!doctype html>
<html lang="es">

<head>
<meta charset="utf-8" />
<title>RentaCar | Crear Vehiculo</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"/>

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

                            <div class="card">

                                <div class="card-header">
                                    Registro de Vehiculo
                                </div>

                                <div class="card-body">

                                    <form action="{{ route('vehiculos.store') }}" method="POST">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Placa</label>
                                                <input type="text" name="plate" class="form-control" id="plate" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Marca</label>
                                                <input type="text" name="brand" class="form-control" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Modelo</label>
                                                <input type="text" name="model" class="form-control" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Ano</label>
                                                <input type="number" name="year" class="form-control" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Tipo de vehiculo</label>
                                                <select name="type" class="form-control" required>
                                                    <option value="">Seleccione</option>
                                                    <option value="sedan">Sedan</option>
                                                    <option value="pickup">Pick-up</option>
                                                    <option value="suv">SUV</option>
                                                    <option value="moto">Moto</option>
                                                    <option value="van">Van</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Capacidad (personas)</label>
                                                <input type="number" name="capacity" class="form-control" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Tipo de combustible</label>
                                                <select name="fuel_type" class="form-control" required>
                                                    <option value="">Seleccione</option>
                                                    <option value="gasolina">Gasolina</option>
                                                    <option value="diesel">Diesel</option>
                                                    <option value="hibrido">Hibrido</option>
                                                    <option value="electrico">Electrico</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Estado</label>
                                                <select name="status" class="form-control" required>
                                                    <option value="available">Disponible</option>
                                                    <option value="assigned">Alquilado</option>
                                                    <option value="maintenance">Mantenimiento</option>
                                                </select>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label>Imagen del vehiculo (URL o ruta)</label>
                                                <input type="text" name="image" class="form-control" placeholder="https://... o /img/car.jpg">
                                            </div>

                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            Guardar Vehiculo
                                        </button>

                                        <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">
                                            Cancelar
                                        </a>

                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>
                @else
                    <div class="alert alert-danger">
                        No tienes permiso para registrar vehiculos.
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
