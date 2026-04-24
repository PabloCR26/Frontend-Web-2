<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8"/>
<title>RentaCar | Editar Usuario</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"/>

<link rel="stylesheet" href="{{ asset('css/adminlte.css') }}"/>

</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

@include('layouts.navbar')
@include('layouts.sidebar')

<main class="app-main">

{{-- HEADER --}}
<div class="app-content-header">
<div class="container-fluid">

<div class="row">

<div class="col-sm-6">
<h3 class="mb-0">Editar Usuario</h3>
</div>

<div class="col-sm-6">

<ol class="breadcrumb float-sm-end">

<li class="breadcrumb-item">
<a href="{{ route('dashboard') }}">Inicio</a>
</li>

<li class="breadcrumb-item">
<a href="{{ route('users.index') }}">Usuarios</a>
</li>

<li class="breadcrumb-item active">
Editar
</li>

</ol>

</div>

</div>

</div>
</div>


{{-- CONTENIDO --}}
<div class="app-content">
<div class="container-fluid">

<div class="row">
<div class="col-lg-8">

<div class="card">

<div class="card-header">
<h3 class="card-title">Actualizar información del usuario</h3>
</div>

<div class="card-body">

{{-- ERRORES --}}
@if ($errors->any())

<div class="alert alert-danger">
<ul class="mb-0">

@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach

</ul>
</div>

@endif


<form action="{{ route('users.update', data_get($user,'id')) }}" method="POST">

@csrf
@method('PUT')

{{-- NOMBRE --}}
<div class="mb-3">

<label class="form-label">Nombre</label>

<input
type="text"
name="name"
class="form-control"
value="{{ old('name', data_get($user,'name')) }}"
required>

</div>


{{-- EMAIL --}}
<div class="mb-3">

<label class="form-label">Email</label>

<input
type="email"
name="email"
class="form-control"
value="{{ old('email', data_get($user,'email')) }}"
required>

</div>


{{-- TELEFONO --}}
<div class="mb-3">

<label class="form-label">Teléfono</label>

<input
type="text"
name="telephone"
class="form-control"
value="{{ old('telephone', data_get($user,'telephone')) }}"
required>

</div>


{{-- PASSWORD --}}
<div class="mb-3">

<label class="form-label">Nueva contraseña (opcional)</label>

<input
type="password"
name="password"
class="form-control"
placeholder="Dejar vacío si no desea cambiarla">

</div>


{{-- ROL --}}
<div class="mb-3">

<label class="form-label">Rol</label>

<select name="role_id" class="form-control">

<option value="1" {{ ($user['role_id'] ?? '') == 1 ? 'selected' : '' }}>
Administrador
</option>

<option value="2" {{ ($user['role_id'] ?? '') == 2 ? 'selected' : '' }}>
Operador
</option>

<option value="3" {{ ($user['role_id'] ?? '') == 3 ? 'selected' : '' }}>
Chofer
</option>

</select>

</div>


{{-- BOTONES --}}
<div class="d-flex justify-content-between">

<a href="{{ route('users.index') }}"
class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>
Volver

</a>

<button type="submit"
class="btn btn-success">

<i class="bi bi-check-circle"></i>
Actualizar Usuario

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