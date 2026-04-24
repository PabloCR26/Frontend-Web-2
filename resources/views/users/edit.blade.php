<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>RentaCar | Editar Usuario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
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
                            <h3 class="mb-0">Editar Usuario: <span class="text-primary">{{ data_get($user, 'name') }}</span></h3>
                        </div>
                        <div class="col-sm-6 text-end">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Volver al listado
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">

                            {{-- ERRORES CON ESTILO --}}
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
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

                            <div class="card card-info card-outline shadow-sm">
                                <div class="card-header">
                                    <h3 class="card-title fw-bold">Actualizar información del usuario</h3>
                                </div>

                                <div class="card-body">
                                    <form action="{{ route('users.update', data_get($user, 'id')) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="row g-3">

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Nombre Completo <span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ old('name', data_get($user, 'name')) }}" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Correo Electrónico <span class="text-danger">*</span></label>
                                                <input type="email" name="email" class="form-control"
                                                    value="{{ old('email', data_get($user, 'email')) }}" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Teléfono <span class="text-danger">*</span></label>
                                                <input type="text" name="telephone" class="form-control"
                                                    value="{{ old('telephone', data_get($user, 'telephone')) }}" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Rol en el Sistema <span class="text-danger">*</span></label>
                                                <select name="role_id" class="form-select" required>
                                                    <option value="">Seleccione un rol</option>
                                                    <option value="1" {{ old('role_id', data_get($user, 'role_id')) == 1 ? 'selected' : '' }}>Administrador</option>
                                                    <option value="2" {{ old('role_id', data_get($user, 'role_id')) == 2 ? 'selected' : '' }}>Conductor</option>
                                                    <option value="3" {{ old('role_id', data_get($user, 'role_id')) == 3 ? 'selected' : '' }}>Operador</option>
                                                </select>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label fw-bold text-muted">Nueva contraseña (Opcional)</label>
                                                <input type="password" name="password" class="form-control" placeholder="Dejar en blanco para mantener la actual">
                                                <div class="form-text">Mínimo 6 caracteres. Si no deseas cambiar la contraseña de este usuario, ignora este campo.</div>
                                            </div>

                                        </div>

                                        <hr class="mt-4">

                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-save"></i> Guardar Cambios
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
                </div>
            </div>

        </main>

        @include('layouts.footer')

    </div>

    <script src="{{ asset('js/adminlte.js') }}"></script>

</body>

</html>