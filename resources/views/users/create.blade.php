<!doctype html>
<html lang="es">

<head>
<meta charset="utf-8">
<title>Crear Usuario</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

@include('layouts.navbar')
@include('layouts.sidebar')

<main class="app-main">

<!-- HEADER -->
<div class="app-content-header">
<div class="container-fluid">

<div class="row">

<div class="col-sm-6">
<h3 class="mb-0">Crear Usuario</h3>
</div>

<div class="col-sm-6 text-end">

<a href="{{ route('users.index') }}" class="btn btn-secondary">
<i class="bi bi-arrow-left"></i> Volver
</a>

</div>

</div>

</div>
</div>

<div class="app-content">
<div class="container-fluid">

{{-- ERRORES --}}
@if($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif


<div class="card card-info card-outline">

<div class="card-header">
<h3 class="card-title">Formulario de Usuario</h3>
</div>

<div class="card-body">

<form action="{{ route('users.store') }}" method="POST">

@csrf

<div class="row">

<!-- NOMBRE -->
<div class="col-md-6 mb-3">

<label class="form-label">Nombre</label>

<input type="text"
name="name"
class="form-control"
value="{{ old('name') }}"
required>

</div>


<!-- EMAIL -->
<div class="col-md-6 mb-3">

<label class="form-label">Email</label>

<input type="email"
name="email"
class="form-control"
value="{{ old('email') }}"
required>

</div>


<!-- TELEFONO -->
<div class="col-md-6 mb-3">

<label class="form-label">Teléfono</label>

<input type="text"
name="telephone"
class="form-control"
value="{{ old('telephone') }}"
required>

</div>


<!-- ROLE -->
<div class="col-md-6 mb-3">

<label class="form-label">Rol</label>

<select name="role_id" class="form-control">

<option value="1">Administrador</option>
<option value="2">Conductor</option>
<option value="2">Operador</option>

</select>

</div>


<!-- PASSWORD -->
<div class="col-md-6 mb-3">

<label class="form-label">Contraseña</label>

<input type="password"
name="password"
class="form-control"
required>

</div>

</div>


<div class="mt-3">

<button class="btn btn-success">

<i class="bi bi-save"></i> Guardar Usuario

</button>

<a href="{{ route('users.index') }}" class="btn btn-secondary">

Cancelar

</a>

</div>

</form>

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