<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $title }}</title>
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="./libs/jsvectormap/dist/jsvectormap.css?1744816593" rel="stylesheet" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler.css?1744816593" rel="stylesheet" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PLUGINS STYLES -->
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-flags.css?1744816593" rel="stylesheet" />
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-socials.css?1744816593" rel="stylesheet" />
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-payments.css?1744816593" rel="stylesheet" />
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-vendors.css?1744816593" rel="stylesheet" />
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-marketing.css?1744816593" rel="stylesheet" />
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-themes.css?1744816593" rel="stylesheet" />
    <!-- END PLUGINS STYLES -->
    <!-- BEGIN DEMO STYLES -->
    <link href="./preview/css/demo.css?1744816593" rel="stylesheet" />
    <!-- END DEMO STYLES -->
    <!-- BEGIN CUSTOM FONT -->
    <style>
        @import url("https://rsms.me/inter/inter.css");
    </style>
    <!-- END CUSTOM FONT -->
</head>

<body>
    <!-- BEGIN GLOBAL THEME SCRIPT -->
    <script src="/tabler-1.2.0/dashboard/dist/js/tabler-theme.min.js?1744816593"></script>
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
                    <img src="/images/logo.png" style="max-height: 100px;">
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
                                    <a class="nav-link dropdown-toggle {{ $isParentActive ? 'active' : '' }}"
                                        href="#menu-{{ $menu->id }}" data-bs-toggle="dropdown" role="button">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            {!! $menu->icon !!}
                                        </span>
                                        <span class="nav-link-title">{{ $menu->label }}</span>
                                    </a>
                                    <div class="dropdown-menu">
                                        @foreach ($menu->children as $child)
                                            <a class="dropdown-item {{ request()->is(ltrim($child->url, '/')) ? 'active' : '' }}"
                                                href="{{ $child->url }}">
                                                {!! $child->icon !!} {{ $child->label }}
                                            </a>
                                        @endforeach
                                    </div>
                                </li>
                            @else
                                <li class="nav-item {{ request()->is(ltrim($menu->url, '/')) ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ $menu->url }}">
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
    <script src="./libs/apexcharts/dist/apexcharts.min.js?1744816593" defer></script>
    <script src="./libs/jsvectormap/dist/jsvectormap.min.js?1744816593" defer></script>
    <script src="./libs/jsvectormap/dist/maps/world.js?1744816593" defer></script>
    <script src="./libs/jsvectormap/dist/maps/world-merc.js?1744816593" defer></script>
    <!-- END PAGE LIBRARIES -->
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="/tabler-1.2.0/dashboard/dist/js/tabler.min.js?1744816593" defer></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <!-- BEGIN DEMO SCRIPTS -->
    <script src="./preview/js/demo.min.js?1744816593" defer></script>
    <!-- END DEMO SCRIPTS -->
    <!-- BEGIN PAGE SCRIPTS -->

    <!-- END PAGE SCRIPTS -->
</body>

</html>
