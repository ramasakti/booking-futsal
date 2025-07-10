<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Sign in.</title>
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
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <img src="/images/logo.png" style="max-height: 100px;">
            </div>
            <div class="card card-md">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Login to your account</h2>
                    @session('failed')
                        <div class="alert alert-danger" role="alert">
                            <div class="alert-icon">
                                <!-- Download SVG icon from http://tabler.io/icons/icon/alert-circle -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon alert-icon icon-2">
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                    <path d="M12 8v4" />
                                    <path d="M12 16h.01" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="alert-heading">Maaf&hellip;</h4>
                                <div class="alert-description">
                                    {{ session('failed') }}
                                </div>
                            </div>
                        </div>
                    @endsession
                    <form action="{{ route('authenticate') }}" method="post" autocomplete="off" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email address</label>
                            <input type="email" class="form-control" placeholder="your@email.com" autocomplete="off"
                                name="email" />
                        </div>
                        <div class="mb-2">
                            <label class="form-label">
                                Password
                            </label>
                            <div class="input-group input-group-flat">
                                <input type="password" class="form-control" placeholder="Your password"
                                    autocomplete="off" name="password" />
                            </div>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="/tabler-1.2.0/dashboard/dist/js/tabler.min.js" defer></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <!-- END PAGE SCRIPTS -->
</body>

</html>
