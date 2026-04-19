<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>RentaCar | Crear Vehículo</title>

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
                        <h3 class="mb-0">Crear Vehículo</h3>
                    </div>
                </div>

            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-md-9">

                        <div class="card">

                            <div class="card-header">
                                Registro de Vehículo
                            </div>

                            <div class="card-body">

                                <form action="{{ route('vehiculos.store') }}" method="POST">
                                    @csrf

                                    <div class="row">

                                        {{-- PLACA --}}
                                        <div class="col-md-6 mb-3">
                                            <label>Placa</label>
                                            <input type="text" name="placa" class="form-control" required>
                                        </div>

                                        {{-- MARCA --}}
                                        <div class="col-md-6 mb-3">
                                            <label>Marca</label>
                                            <input type="text" name="marca" class="form-control" required>
                                        </div>

                                        {{-- MODELO --}}
                                        <div class="col-md-6 mb-3">
                                            <label>Modelo</label>
                                            <input type="text" name="modelo" class="form-control" required>
                                        </div>

                                        {{-- AÑO --}}
                                        <div class="col-md-6 mb-3">
                                            <label>Año</label>
                                            <input type="number" name="anio" class="form-control" required>
                                        </div>

                                        {{-- TIPO VEHÍCULO --}}
                                        <div class="col-md-6 mb-3">
                                            <label>Tipo de vehículo</label>
                                            <select name="tipo" class="form-control" required>
                                                <option value="">Seleccione</option>
                                                <option value="sedan">Sedán</option>
                                                <option value="pickup">Pick-up</option>
                                                <option value="suv">SUV</option>
                                                <option value="moto">Moto</option>
                                                <option value="van">Van</option>
                                            </select>
                                        </div>

                                        {{-- CAPACIDAD --}}
                                        <div class="col-md-6 mb-3">
                                            <label>Capacidad (personas)</label>
                                            <input type="number" name="capacidad" class="form-control" required>
                                        </div>

                                        {{-- COMBUSTIBLE --}}
                                        <div class="col-md-6 mb-3">
                                            <label>Tipo de combustible</label>
                                            <select name="combustible" class="form-control" required>
                                                <option value="">Seleccione</option>
                                                <option value="gasolina">Gasolina</option>
                                                <option value="diesel">Diésel</option>
                                                <option value="hibrido">Híbrido</option>
                                                <option value="electrico">Eléctrico</option>
                                            </select>
                                        </div>

                                        {{-- ESTADO --}}
                                        <div class="col-md-6 mb-3">
                                            <label>Estado</label>
                                            <select name="estado" class="form-control" required>
                                                <option value="disponible">Disponible</option>
                                                <option value="alquilado">Alquilado</option>
                                                <option value="mantenimiento">Mantenimiento</option>
                                            </select>
                                        </div>

                                        {{-- IMAGEN --}}
                                        <div class="col-md-12 mb-3">
                                            <label>Imagen del vehículo (URL o ruta)</label>
                                            <input type="text" name="imagen" class="form-control" placeholder="https://... o /img/car.jpg">
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        Guardar Vehículo
                                    </button>

                                    <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">
                                        Cancelar
                                    </a>

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