<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Booking Lapangan</title>
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler.css" rel="stylesheet" />
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-flags.css" rel="stylesheet" />
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-socials.css" rel="stylesheet" />
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-payments.css" rel="stylesheet" />
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-vendors.css" rel="stylesheet" />
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-marketing.css" rel="stylesheet" />
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler-themes.css" rel="stylesheet" />
</head>

<body>
    <div class="page-wrapper">
        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Invoice</h2>
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                        <button type="button" class="btn btn-primary" onclick="javascript:window.print();">
                            <!-- Download SVG icon from http://tabler.io/icons/icon/printer -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-1">
                                <path
                                    d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                <path
                                    d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                            </svg>
                            Print Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE HEADER -->
        <!-- BEGIN PAGE BODY -->
        <div class="page-body">
            <div class="container-xl">
                <div class="card card-lg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="h3">Futsal Srikandi</p>
                                <address>
                                    {{-- Street Address<br />
                                    State, City<br />
                                    Region, Postal Code<br />
                                    ltd@example.com --}}
                                </address>
                            </div>
                            <div class="col-6 text-end">
                                <p class="h3">{{ $booking->pemesan->name }}</p>
                                <address>
                                    {{ $booking->pemesan->email }}<br />
                                    {{ $booking->created_at->translatedFormat('l, d F Y H.i') }}<br />
                                    {{-- Region, Postal Code<br /> --}}
                                    {{-- ctr@example.com  --}}
                                </address>
                            </div>
                            <div class="col-12 my-5">
                                <h1>{{ $booking->payment_reference }}</h1>
                            </div>
                        </div>
                        <table class="table table-transparent table-responsive">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 1%"></th>
                                    <th>Item</th>
                                    <th class="text-center" style="width: 10%">Durasi</th>
                                    <th class="text-end" style="width: 10%">Harga</th>
                                    <th class="text-end" style="width: 10%">Subtotal</th>
                                </tr>
                            </thead>
                            <tr>
                                <td class="text-center"></td>
                                <td>
                                    <p class="strong mb-1">Booking {{ $booking->lapangan->nama_lapangan }}</p>
                                    {{-- <div class="text-secondary">Logo and business cards design</div> --}}
                                </td>
                                <td class="text-center">{{ number_format($booking->durasi_jam, 0, ',', '.') }}</td>
                                <td class="text-end">Rp. {{ number_format($booking->lapangan->harga, 0, ',', '.') }}</td>
                                <td class="text-end">Rp. {{ number_format($booking->lapangan->harga * $booking->durasi_jam, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="font-weight-bold text-uppercase text-end">Total Due</td>
                                <td class="font-weight-bold text-end">Rp. {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                        <p class="text-secondary text-center mt-5">
                            Terima Kasih!
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE BODY -->
    </div>
</body>
<!-- BEGIN PAGE LIBRARIES -->
<script src="/tabler-1.2.0/dashboard/libs/apexcharts/dist/apexcharts.min.js" defer></script>
<script src="/tabler-1.2.0/dashboard/libs/jsvectormap/dist/jsvectormap.min.js" defer></script>
<script src="/tabler-1.2.0/dashboard/libs/jsvectormap/dist/maps/world.js" defer></script>
<script src="/tabler-1.2.0/dashboard/libs/jsvectormap/dist/maps/world-merc.js" defer></script>
<!-- END PAGE LIBRARIES -->
<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="/tabler-1.2.0/dashboard/dist/js/tabler.min.js" defer></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

</html>
