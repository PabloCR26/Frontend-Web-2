<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8"/>
<title>RentaCar | Usuarios</title>

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
<h3 class="mb-0">Usuarios</h3>
</div>

<div class="col-sm-6">

<ol class="breadcrumb float-sm-end">

<li class="breadcrumb-item">
<a href="{{ route('dashboard') }}">Inicio</a>
</li>

<li class="breadcrumb-item active">
Usuarios
</li>

</ol>

</div>

</div>

</div>
</div>


{{-- CONTENIDO --}}
<div class="app-content">
<div class="container-fluid">

{{-- BOTON CREAR --}}
<div class="row mb-3">

<div class="col-12 text-end">

<a href="{{ route('users.create') }}" class="btn btn-primary">
<i class="bi bi-person-plus"></i>
Nuevo Usuario
</a>
<div class="mb-3 d-flex gap-2">

<a href="{{ route('users.index') }}"
   class="btn btn-primary {{ !request('status') ? 'active' : '' }}">
   Activos
</a>

<a href="{{ route('users.index', ['status' => 'deleted']) }}"
   class="btn btn-danger {{ request('status') == 'deleted' ? 'active' : '' }}">
   Eliminados
</a>

</div>
</div>

</div>


{{-- MENSAJES --}}
@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
{{ session('error') }}
</div>
@endif


{{-- TABLA --}}
<div class="row">

<div class="col-12">

<div class="card">

<div class="card-header">
<h3 class="card-title">Lista de Usuarios</h3>
</div>


<div class="card-body table-responsive">

<table class="table table-bordered table-hover">

<thead class="table-light">

<tr>
<th>ID</th>
<th>Nombre</th>
<th>Email</th>
<th>Teléfono</th>
<th>Rol</th>
<th width="150">Acciones</th>
</tr>

</thead>

<tbody>

@if(isset($users) && count($users) > 0)

@foreach($users as $user)

@if(is_array($user) && isset($user['id']))

<tr>

<td>{{ $user['id'] }}</td>

<td>{{ $user['name'] ?? '' }}</td>

<td>{{ $user['email'] ?? '' }}</td>

<td>{{ $user['telephone'] ?? '' }}</td>

<td>

@if(isset($user['role']['name']))

<span class="badge text-bg-primary">
{{ $user['role']['name'] }}
</span>

@else

<span class="badge text-bg-secondary">
Sin rol
</span>

@endif

</td>

<td>

{{-- EDITAR --}}
<a href="{{ route('users.edit',['user'=>$user['id']]) }}"
class="btn btn-sm btn-warning">

<i class="bi bi-pencil"></i>

</a>


{{-- ELIMINAR --}}
<form action="{{ route('users.destroy',['user'=>$user['id']]) }}"
method="POST"
style="display:inline-block">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger"
onclick="return confirm('¿Eliminar usuario?')">

<i class="bi bi-trash"></i>

</button>

</form>

</td>

</tr>

@endif

@endforeach

@else

<tr>

<td colspan="6" class="text-center">
No hay usuarios registrados
</td>

</tr>

@endif

</tbody>

</table>

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