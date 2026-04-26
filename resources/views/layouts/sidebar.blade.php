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
                    <a href="{{ route('dashboard') }}" class="nav-link active">
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

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-car-front-fill"></i>
                        <p>
                            Vehiculos
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        @can('create', \App\Models\Vehicle::class)
                        <li class="nav-item">
                            <a href="{{ route('vehiculos.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Registrar vehiculo</p>
                            </a>
                        </li>
                        @endcan

                        <li class="nav-item">
                            <a href="{{ route('vehiculos.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list-ul"></i>
                                <p>Lista de vehiculos</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @can('create', \App\Models\User::class)
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-person-vcard-fill"></i>
                        <p>
                            Clientes
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-person-plus"></i>
                                <p>Registrar cliente</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-people"></i>
                                <p>Lista de clientes</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-key-fill"></i>
                        <p>
                            Alquileres
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>Nuevo alquiler</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-journal-text"></i>
                                <p>Historial de alquileres</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @can('viewAny', \App\Models\Maintenance::class)
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-tools"></i>
                        <p>
                            Mantenimiento
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        @can('create', \App\Models\Maintenance::class)
                        <li class="nav-item">
                            <a href="{{ route('mantenimientos.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-wrench"></i>
                                <p>Registrar mantenimiento</p>
                            </a>
                        </li>
                        @endcan

                        <li class="nav-item">
                            <a href="{{ route('mantenimientos.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list-check"></i>
                                <p>Historial mantenimiento</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                @can('create', \App\Models\vehicle::class)
                <li class="nav-header">REPORTES</li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-bar-chart-fill"></i>
                        <p>
                            Reportes
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-graph-up"></i>
                                <p>Ingresos</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-car-front"></i>
                                <p>Vehiculos activos</p>
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