<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/img/AdminLTELogo.png') }}"
                alt="RentaCar Logo"
                class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">RentaCar</span>
        </a>
    </div>

    <div class="sidebar-wrapper">

        <nav class="mt-2">

            <ul class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="navigation"
                data-accordion="false"
                id="navigation">

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @can('update', \App\Models\Request::class)
                <li class="nav-header">GESTION DE SOLICITUDES</li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-list-ul"></i>
                        <p>
                            Listado
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-person-gear"></i>
                                <p>Ver</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                <li class="nav-header">GESTION DE FLOTA</li>

                <li class="nav-item {{ request()->routeIs('vehiculos.*', 'solicitudes.*', 'viajes.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('vehiculos.*', 'solicitudes.*', 'viajes.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-car-front-fill"></i>
                        <p>
                            Vehiculos
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('create', \App\Models\Vehicle::class)
                        <li class="nav-item">
                            <a href="{{ route('vehiculos.create') }}" class="nav-link {{ request()->routeIs('vehiculos.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Registrar vehiculo</p>
                            </a>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('vehiculos.index') }}" class="nav-link {{ request()->routeIs('vehiculos.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-list-ul"></i>
                                <p>Lista de vehiculos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('solicitudes.index') }}" class="nav-link {{ request()->routeIs('solicitudes.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-card-checklist"></i>
                                <p>Solicitudes</p>
                            </a>
                        </li>
                        
                        {{-- 🔥 NUEVO: VIAJES ACTIVOS (Solo Admin y Operador) --}}
                        @if(in_array(auth()->user()->role_id, [1, 2]))
                        <li class="nav-item">
                            <a href="{{ route('viajes.index') }}" class="nav-link {{ request()->routeIs('viajes.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-geo-alt"></i>
                                <p>Viajes Activos</p>
                            </a>
                        </li>
                        @endif

                    </ul>
                </li>

                @can('create', \App\Models\User::class)
                <li class="nav-item {{ request()->routeIs('users.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-vcard-fill"></i>
                        <p>
                            Clientes
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users.create') }}" class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-plus"></i>
                                <p>Registrar cliente</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-people"></i>
                                <p>Lista de clientes</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                @can('viewAny', \App\Models\Route::class)
                <li class="nav-item {{ request()->routeIs('rutas.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('rutas.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-map-fill"></i>
                        <p>
                            Rutas
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('create', \App\Models\Route::class)
                        <li class="nav-item">
                            <a href="{{ route('rutas.create') }}" class="nav-link {{ request()->routeIs('rutas.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Crear ruta</p>
                            </a>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('rutas.index') }}" class="nav-link {{ request()->routeIs('rutas.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-journal-text"></i>
                                <p>Historial de rutas</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                @can('viewAny', \App\Models\Maintenance::class)
                    <li class="nav-item {{ request()->routeIs('mantenimientos.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('mantenimientos.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-tools"></i>
                            <p>
                                Mantenimiento
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('create', \App\Models\Maintenance::class)
                                <li class="nav-item">
                                    <a href="{{ route('mantenimientos.create') }}" class="nav-link {{ request()->routeIs('mantenimientos.create') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-wrench"></i>
                                        <p>Registrar mantenimiento</p>
                                    </a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ route('mantenimientos.index') }}" class="nav-link {{ request()->routeIs('mantenimientos.index') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-list-check"></i>
                                    <p>Historial mantenimiento</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('create', \App\Models\Vehicle::class)
                <li class="nav-header">REPORTES</li>

                <li class="nav-item {{ request()->routeIs('reports.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-bar-chart-fill"></i>
                        <p>
                            Reportes
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('reports.availability') }}" class="nav-link {{ request()->routeIs('reports.availability') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-calendar-check"></i>
                                <p>Disponibilidad</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.fleet-usage') }}" class="nav-link {{ request()->routeIs('reports.fleet-usage') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-truck"></i>
                                <p>Uso de flotilla</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.driver-history') }}" class="nav-link {{ request()->routeIs('reports.driver-history') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-lines-fill"></i>
                                <p>Historial chofer</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                <li class="nav-header">SISTEMA</li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-gear-fill"></i>
                        <p>
                            Configuracion
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-person-gear"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

        </nav>

    </div>

</aside>