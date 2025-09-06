<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $title }}</title>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler.css" rel="stylesheet" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PLUGINS STYLES -->
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-flags.css" rel="stylesheet" />
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-socials.css" rel="stylesheet" />
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-payments.css" rel="stylesheet" />
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-vendors.css" rel="stylesheet" />
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-marketing.css" rel="stylesheet" />
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-themes.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" type="text/css" href="/datatables/datatables.min.css">
    <link href="/tabler-1.2.0/dashboard/libs/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <link href="/dropzone.css" rel="stylesheet">
    <!-- END PLUGINS STYLES -->
    <!-- BEGIN CUSTOM FONT -->
    <style>
        @import url("https://rsms.me/inter/inter.css");
    </style>
    <!-- END CUSTOM FONT -->
</head>

<body>
    <!-- BEGIN GLOBAL THEME SCRIPT -->
    <script src="/tabler-1.2.0/dashboard/dist/js/tabler-theme.min.js"></script>
    <!-- END GLOBAL THEME SCRIPT -->
    <div class="page">
        <!--  BEGIN SIDEBAR  -->
        <aside class="navbar navbar-vertical navbar-expand-lg navbar-transparent">
            <div class="container-fluid">
                <!-- BEGIN NAVBAR TOGGLER -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                    aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- END NAVBAR TOGGLER -->
                <!-- BEGIN NAVBAR LOGO -->
                <div class="navbar-brand navbar-brand-autodark">
                    <a href="/">
                        <img src="/images/logo.jpeg" class="rounded-circle" style="max-height: 100px;">
                    </a>
                </div>
                <div class="nav-item dropdown">
                    <div class="nav-item d-flex align-items-center">
                        <div class="d-flex align-items-center ms-2">
                            <span class="avatar">
                                @php
                                    $nama = explode(' ', Auth::user()->name);
                                    $inisial = '';
                                    foreach ($nama as $nama) {
                                        if (!empty($nama)) {
                                            $inisial .= strtoupper($nama[0]);
                                        }
                                    }
                                @endphp
                                {{ $inisial }}
                            </span>
                            <div class="d-none d-xl-block ps-2">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="mt-1 small text-secondary">
                                    {{ session('roles')->pluck('role')->pluck('role')->implode(', ') }}
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('logout') }}" class="ms-2 d-flex align-items-right text-danger ms-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-logout">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                <path d="M9 12h12l-3 -3" />
                                <path d="M18 15l3 -3" />
                            </svg>
                        </a>
                    </div>
                    {{-- <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow show" data-bs-popper="static">
                        <a href="/logout" class="dropdown-item">Logout</a>
                    </div> --}}
                </div>
                <!-- END NAVBAR LOGO -->

                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <!-- BEGIN NAVBAR MENU -->
                    <ul class="navbar-nav pt-lg-3">
                        @foreach ($menus as $menu)
                            @if ($menu->children->count())
                                @php
                                    $isParentActive = $menu->children->contains(
                                        fn($child) => request()->is(ltrim($child->url, '/')),
                                    );
                                @endphp
                                <li class="nav-item dropdown {{ $isParentActive ? 'active' : '' }}">
                                    <a class="nav-link dropdown-toggle {{ request()->is(ltrim(replaceSessionPlaceholders($menu->url), '/')) ? 'active' : '' }}"
                                        href="{{ replaceSessionPlaceholders($menu->url) }}" data-bs-toggle="dropdown"
                                        role="button">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            {!! $menu->icon !!}
                                        </span>
                                        <span class="nav-link-title">
                                            {{ replaceSessionPlaceholders($menu->label) }}
                                        </span>
                                    </a>
                                    <div class="dropdown-menu">
                                        @foreach ($menu->children as $child)
                                            <a class="dropdown-item {{ request()->is(ltrim($child->url, '/')) ? 'active' : '' }}"
                                                href="{{ $child->url }}">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    {!! $child->icon !!}
                                                </span>
                                                <span class="nav-link-title">
                                                    {{ replaceSessionPlaceholders($child->label) }}
                                                </span>
                                            </a>
                                        @endforeach
                                    </div>
                                </li>
                            @else
                                <li
                                    class="nav-item {{ request()->is(ltrim(replaceSessionPlaceholders($menu->url), '/')) ? 'active' : '' }}">
                                    <a class="nav-link {{ request()->is(ltrim(replaceSessionPlaceholders($menu->url), '/')) ? 'active' : '' }}"
                                        href="{{ replaceSessionPlaceholders($menu->url) }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            {!! $menu->icon !!}
                                        </span>
                                        <span class="nav-link-title">{{ $menu->label }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <!-- END NAVBAR MENU -->
                </div>
            </div>
        </aside>
        <!--  END SIDEBAR  -->
        <div class="page-wrapper">
            <!-- BEGIN PAGE HEADER -->
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <!-- Page pre-title -->
                            <div class="page-pretitle">
                                @php
                                    $path = request()->server('PATH_INFO');
                                    $breadcrumbs = explode('/', $path);
                                @endphp
                                <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                    @foreach ($breadcrumbs as $bread)
                                        <li class="breadcrumb-item">
                                            <a href="#">{{ $bread }}</a>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                            <h2 class="page-title">{{ $title }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE HEADER -->
            <!-- BEGIN PAGE BODY -->
            <div class="page-body">
                <div class="container-xl">
                    {{ $slot }}
                </div>
            </div>
            <!-- END PAGE BODY -->
        </div>
    </div>
    <!-- BEGIN PAGE LIBRARIES -->
    <script src="/tabler-1.2.0/dashboard/libs/apexcharts/dist/apexcharts.min.js" defer></script>
    <script src="/tabler-1.2.0/dashboard/libs/jsvectormap/dist/jsvectormap.min.js" defer></script>
    <script src="/tabler-1.2.0/dashboard/libs/jsvectormap/dist/maps/world.js" defer></script>
    <script src="/tabler-1.2.0/dashboard/libs/jsvectormap/dist/maps/world-merc.js" defer></script>
    <!-- END PAGE LIBRARIES -->
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="/tabler-1.2.0/dashboard/dist/js/tabler.min.js" defer></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    {{-- Vendor --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
        integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/datatables/datatables.min.js"></script>
    <script src="/tabler-1.2.0/dashboard/libs/tom-select/dist/js/tom-select.complete.min.js"></script>
    {{-- End Vendor --}}
    <!-- BEGIN PAGE SCRIPTS -->
    <script>
        @if ($message = Session::get('success'))
            Toastify({
                text: "{!! $message !!}",
                duration: 3000,
                position: "center",
                style: {
                    background: "#0ca678"
                }
            }).showToast();
        @elseif (count($errors) > 0)
            @foreach ($errors->all() as $error)
                Toastify({
                    text: "{!! $error !!}",
                    duration: 3000,
                    position: "center",
                    style: {
                        background: "#d63939"
                    }
                }).showToast();
            @endforeach
        @elseif ($message = Session::get('failed'))
            Toastify({
                text: "{!! $message !!}",
                duration: 3000,
                position: "center",
                style: {
                    background: "#d63939"
                }
            }).showToast();
        @endif
    </script>
    <!-- END PAGE SCRIPTS -->
</body>

</html>
