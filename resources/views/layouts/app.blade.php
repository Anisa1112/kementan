<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="../../assets/" data-template="admin">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title', 'Dashboard Portal Kementan')</title>
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/kementan-logo.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>
    <script src="../../assets/vendor/js/template-customizer.js"></script>
    <script src="../../assets/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('home') }}" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img width="24" height="24" src="../../assets/img/kementan-logo.png"
                                alt="Logo" />
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold">Kementan</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">

                    <!-- Beranda -->
                    <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-smart-home"></i>
                            <div data-i18n="Beranda">Beranda</div>
                        </a>
                    </li>



                    <!-- Komoditas (Dropdown) -->

                        <li class="menu-item {{ request()->is('komoditas/sektor/*') || request()->is('psp') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons ti ti-database"></i>
                                <div data-i18n="Komoditas">Komoditas</div>
                            </a>
                            <ul class="menu-sub">
                                @if (hasPermission('access_sector_pangan'))
                                    <li class="menu-item {{ request()->is('komoditas/sektor/tanaman-pangan') ? 'active' : '' }}">
                                        <a href="{{ route('komoditas.sektor', 'tanaman-pangan') }}" class="menu-link">
                                            <div data-i18n="Tanaman Pangan">Tanaman Pangan</div>
                                        </a>
                                    </li>
                                @endif
                                @if (hasPermission('access_sector_horti'))
                                <li class="menu-item {{ request()->is('komoditas/sektor/hortikultura') ? 'active' : '' }}">
                                    <a href="{{ route('komoditas.sektor', 'hortikultura') }}" class="menu-link">
                                        <div data-i18n="Hortikultura">Hortikultura</div>
                                    </a>
                                </li>
                                @endif
                                @if (hasPermission('access_sector_perkebunan'))
                                <li class="menu-item {{ request()->is('komoditas/sektor/perkebunan') ? 'active' : '' }}">
                                    <a href="{{ route('komoditas.sektor', 'perkebunan') }}" class="menu-link">
                                        <div data-i18n="Perkebunan">Perkebunan</div>
                                    </a>
                                </li>
                                @endif
                                @if (hasPermission('access_sector_peternakan'))
                                 <li class="menu-item {{ request()->is('komoditas/sektor/peternakan') ? 'active' : '' }}">
                                    <a href="{{ route('komoditas.sektor', 'peternakan') }}" class="menu-link">
                                        <div data-i18n="Peternakan">Peternakan & Kesehatan Hewan</div>
                                    </a>
                                </li>
                                @endif
                                @if (hasPermission('access_psp'))
                                <li class="menu-item {{ request()->routeIs('komoditas') && request()->get('tab') == 'psp' ? 'active' : '' }}">
                                    <a href="{{ route('komoditas') }}?tab=psp" class="menu-link">
                                        <div data-i18n="Prasarana dan Sarana">Prasarana & Sarana</div>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>


                    <!-- Data Komoditas -->
                    <li class="menu-item {{ request()->routeIs('komoditas') && request()->get('tab') != 'psp' ? 'active' : '' }}">
                        <a href="{{ route('komoditas') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-table"></i>
                            <div data-i18n="Data Komoditas">Data Komoditas</div>
                        </a>
                    </li>

                    <!-- Admin Panel -->
                    @auth
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
                            <li class="menu-item {{ request()->routeIs('admin') ? 'active' : '' }}">
                                <a href="{{ route('admin') }}" class="menu-link">
                                    <i class="menu-icon tf-icons ti ti-settings"></i>
                                    <div data-i18n="Admin Panel">Admin Panel</div>
                                </a>
                            </li>
                        @endif
                    @endauth

                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout page -->
            <div class="layout-page">

             <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="ti ti-menu-2 ti-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Quick Menu -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle px-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <i class="ti ti-layout-grid ti-md me-2"></i>
                                    <span class="d-none d-md-inline-block text-muted">Menu Cepat</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <h6 class="dropdown-header">Navigasi</h6>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('home') }}">
                                            <i class="ti ti-home me-2"></i>
                                            <span class="align-middle">Beranda</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('komoditas') }}">
                                            <i class="ti ti-database me-2"></i>
                                            <span class="align-middle">Data Master Komoditas</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <h6 class="dropdown-header">Data Per Sektor</h6>
                                    </li>
                                    @if (hasPermission('accsess_sector_pangan'))
                                    <li>
                                        <a class="dropdown-item" href="{{ route('komoditas.sektor', 'tanaman-pangan') }}">
                                            <i class="ti ti-plant-2 me-2 text-success"></i>
                                            <span class="align-middle">Tanaman Pangan</span>
                                        </a>
                                    </li>
                                    @endif
                                    @if (hasPermission('accsess_sector_horti'))
                                    <li>
                                        <a class="dropdown-item" href="{{ route('komoditas.sektor', 'hortikultura') }}">
                                            <i class="ti ti-flower me-2 text-warning"></i>
                                            <span class="align-middle">Hortikultura</span>
                                        </a>
                                    </li>
                                    @endif
                                    @if (hasPermission('accsess_sector_perkebunan'))
                                    <li>
                                        <a class="dropdown-item" href="{{ route('komoditas.sektor', 'perkebunan') }}">
                                            <i class="ti ti-tree me-2 text-danger"></i>
                                            <span class="align-middle">Perkebunan</span>
                                        </a>
                                    </li>
                                    @endif
                                    @if (hasPermission('accsess_sector_peternakan'))
                                    <li>
                                        <a class="dropdown-item" href="{{ route('komoditas.sektor', 'peternakan') }}">
                                            <i class="ti ti-paw me-2 text-info"></i>
                                            <span class="align-middle">Peternakan & Keswan</span>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <!-- /Quick Menu -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Style Switcher -->
                            <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <i class="ti ti-md"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                            <span class="align-middle"><i class="ti ti-sun me-2"></i>Light</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                            <span class="align-middle"><i class="ti ti-moon me-2"></i>Dark</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                            <span class="align-middle"><i
                                                    class="ti ti-device-desktop me-2"></i>System</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- / Style Switcher-->

                            <!-- User Dropdown -->
                            @auth
                                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                        data-bs-toggle="dropdown">
                                        <div class="avatar avatar-online">
                                            <img src="{{ asset('assets/img/avatars/1.png') }}" alt
                                                class="h-auto rounded-circle" />
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile.show') }}">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar avatar-online">
                                                            <img src="{{ asset('assets/img/avatars/1.png') }}" alt
                                                                class="h-auto rounded-circle" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <span class="fw-medium d-block">{{ Auth::user()->name }}</span>
                                                        <small class="text-muted">{{ Auth::user()->role }}</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <i class="ti ti-logout me-2 ti-sm"></i>
                                                    <span class="align-middle">Log Out</span>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endauth

                            {{-- Kalau belum login, tampilkan tombol Login Admin --}}
                            @guest
                                <li class="nav-item">
                                    <a class="btn btn-outline-primary" href="{{ route('login') }}">Login Admin</a>
                                </li>
                            @endguest

                        </ul>
                    </div>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    <!-- / Content -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../../assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="../../assets/vendor/js/menu.js"></script>

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/moment/moment.js"></script>
    <script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="../../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

    <!-- Page JS -->
    @stack('scripts')

</body>

</html>
