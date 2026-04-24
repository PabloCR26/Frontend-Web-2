<!doctype html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RentaCar | Usuarios</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />

    <link rel="preload" href="{{ asset('css/adminlte.css') }}" as="style" />

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        crossorigin="anonymous" media="print" onload="this.media = 'all'" />

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />

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
                            <h3 class="mb-0">Usuarios</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                                <li class="breadcrumb-item active">Listado de Usuarios</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <div class="card card-info card-outline mb-4 shadow-sm">
                                <div class="card-header">
                                    <div class="row w-100 align-items-center">

                                        <div class="col-md-4 mb-2 mb-md-0">
                                            <h5 class="mb-0">Gestión de Usuarios</h5>
                                        </div>

                                        <div class="col-md-4 mb-2 mb-md-0">
                                            <form method="GET" action="{{ route('users.index') }}">
                                                <select name="status" class="form-select form-select-sm"
                                                    onchange="this.form.submit()">
                                                    <option value="" {{ empty($status) ? 'selected' : '' }}>Usuarios Activos</option>
                                                    <option value="deleted" {{ ($status ?? '') === 'deleted' ? 'selected' : '' }}>
                                                        Usuarios Eliminados
                                                    </option>
                                                </select>
                                            </form>
                                        </div>

                                        <div class="col-md-4 text-end">
                                            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-person-plus me-1"></i>
                                                Nuevo Usuario
                                            </a>
                                        </div>

                                    </div>
                                </div>

                                @if (session('success'))
                                    <div class="alert alert-success rounded-0 mb-0">
                                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger rounded-0 mb-0">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger rounded-0 mb-0">
                                        <strong>Se encontraron errores:</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="card-body table-responsive p-0">
                                    <table class="table table-bordered table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 60px;" class="text-center">ID</th>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Teléfono</th>
                                                <th>Rol</th>
                                                <th style="width: 120px;" class="text-center">Estado</th>
                                                <th style="width: 150px;" class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($users as $user)
                                                <tr>
                                                    <td class="text-center">{{ $user['id'] }}</td>
                                                    <td class="fw-bold">{{ $user['name'] }}</td>
                                                    <td>{{ $user['email'] }}</td>
                                                    <td>{{ $user['telephone'] ?? 'N/A' }}</td>
                                                    
                                                    <td>
                                                        @if(isset($user['role']['name']))
                                                            <span class="badge text-bg-primary">{{ $user['role']['name'] }}</span>
                                                        @else
                                                            <span class="badge text-bg-secondary">Sin rol</span>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        @if (($status ?? '') === 'deleted')
                                                            <span class="badge text-bg-danger">Eliminado</span>
                                                        @else
                                                            <span class="badge text-bg-success">Activo</span>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center gap-2">

                                                            @if (($status ?? '') === 'deleted')
                                                                <form action="{{ route('users.restore', $user['id']) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('¿Desea restaurar este usuario?');">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Restaurar">
                                                                        <i class="bi bi-arrow-counterclockwise"></i>
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <a href="{{ route('users.edit', $user['id']) }}"
                                                                    class="btn btn-sm btn-outline-primary" title="Editar">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </a>

                                                                <form action="{{ route('users.destroy', $user['id']) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('¿Está seguro de que desea eliminar este usuario?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endif

                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted py-5">
                                                        <i class="bi bi-people fs-1 d-block mb-2"></i>
                                                        No se encontraron usuarios en esta lista.
                                                    </td>
                                                </tr>
                                            @endforelse
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

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/adminlte.js') }}"></script>

    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };

        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            const isMobile = window.innerWidth <= 992;

            if (
                sidebarWrapper &&
                OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
                !isMobile
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
</body>

</html>