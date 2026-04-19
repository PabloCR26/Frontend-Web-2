<!doctype html>
<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RentaCar | Dashboard</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />

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
<h3 class="mb-0">Dashboard</h3>
</div>

<div class="col-sm-6">

<ol class="breadcrumb float-sm-end">

<li class="breadcrumb-item">
<a href="{{ route('dashboard') }}">Inicio</a>
</li>

<li class="breadcrumb-item active">
Dashboard
</li>

</ol>

</div>

</div>

</div>
</div>


<div class="app-content">
<div class="container-fluid">


{{-- TARJETAS --}}
<div class="row">

<div class="col-lg-3 col-6">

<div class="small-box text-bg-primary">

<div class="inner">
<h3>{{ isset($vehiculos) ? count($vehiculos) : 0 }}</h3>
<p>Vehículos</p>
</div>

<div class="icon">
<i class="bi bi-car-front-fill"></i>
</div>

</div>

</div>


<div class="col-lg-3 col-6">

<div class="small-box text-bg-success">

<div class="inner">
<h3>
{{ isset($vehiculos) ? collect($vehiculos)->where('estado','disponible')->count() : 0 }}
</h3>
<p>Disponibles</p>
</div>

<div class="icon">
<i class="bi bi-check-circle-fill"></i>
</div>

</div>

</div>


<div class="col-lg-3 col-6">

<div class="small-box text-bg-warning">

<div class="inner">
<h3>
{{ isset($vehiculos) ? collect($vehiculos)->where('estado','alquilado')->count() : 0 }}
</h3>
<p>Alquilados</p>
</div>

<div class="icon">
<i class="bi bi-key-fill"></i>
</div>

</div>

</div>


<div class="col-lg-3 col-6">

<div class="small-box text-bg-danger">

<div class="inner">
<h3>
{{ isset($vehiculos) ? collect($vehiculos)->where('estado','mantenimiento')->count() : 0 }}
</h3>
<p>Mantenimiento</p>
</div>

<div class="icon">
<i class="bi bi-tools"></i>
</div>

</div>

</div>

</div>



{{-- TABLA VEHICULOS --}}
<div class="row">

<div class="col-12">

<div class="card">

<div class="card-header">
<h3 class="card-title">
Vehículos recientes
</h3>
</div>

<div class="card-body table-responsive">

<table class="table table-bordered table-hover">

<thead class="table-light">

<tr>

<th>ID</th>
<th>Modelo</th>
<th>Marca</th>
<th>Estado</th>

</tr>

</thead>

<tbody>

@if(isset($vehiculos) && count($vehiculos) > 0)

@foreach($vehiculos as $vehiculo)

<tr>

<td>{{ $vehiculo['id'] }}</td>

<td>{{ $vehiculo['modelo'] }}</td>

<td>{{ $vehiculo['marca'] }}</td>

<td>

@if($vehiculo['estado'] == 'disponible')

<span class="badge text-bg-success">
Disponible
</span>

@elseif($vehiculo['estado'] == 'alquilado')

<span class="badge text-bg-warning">
Alquilado
</span>

@else

<span class="badge text-bg-danger">
Mantenimiento
</span>

@endif

</td>

</tr>

@endforeach

@else

<tr>
<td colspan="4" class="text-center">
No hay vehículos registrados
</td>
</tr>

@endif

</tbody>

</table>

</div>

</div>

</div>

</div>


@yield('dashboard_content')

</div>
</div>

</main>

@include('layouts.footer')

</div>

<script src="{{ asset('js/adminlte.js') }}"></script>

</body>
</html>