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
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="/datatables/datatables.min.css">
    <link href="/tabler-1.2.0/dashboard/libs/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_PUBLIC_KEY') }}"></script>
</head>

<body>
    <div class="page-wrapper">
        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col text-center">
                        <a href="/">
                            <img src="/images/logo.jpeg" class="rounded-circle" style="max-height: 100px;">
                        </a>
                        <h2 class="page-title">Booking Lapangan</h2>
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
                                @include('components.back')
                                <p class="h3">{{ env('APP_NAME') }}</p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="h3">{{ Auth::user()->name }}</p>
                                <address>
                                    {{ Auth::user()->email }} <br />
                                    @if (Auth::user()->saldo > 0)
                                        Saldo Anda: Rp. {{ number_format(Auth::user()->saldo, 0, ',', '.') }}
                                    @endif
                                </address>
                            </div>
                            <div class="col-12 my-5">
                                <form action="" method="get">
                                    <div class="mb-3">
                                        <select name="lapangan_id" class="form-select" onchange="this.form.submit()">
                                            <option selected disabled>Pilih Lapangan</option>
                                            @foreach ($lapangans as $lapangan)
                                                <option value="{{ $lapangan->id }}" @selected($lapangan->id == request('lapangan_id'))>
                                                    {{ $lapangan->nama_lapangan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                                @if (request('lapangan_id'))
                                    <div class="row text-center g-2">
                                        @foreach ($selected_lapangan->foto as $foto)
                                            <div class="col-4">
                                                <img src="/{{ $foto->foto }}" class="rounded"
                                                    style="max-height: 200px;">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <h1>Lapangan</h1>
                                @endif
                            </div>
                        </div>

                        <form id="bookingForm">
                            @csrf
                            <input type="hidden" name="lapangan_id" value="{{ request('lapangan_id') }}">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input type="text" name="tanggal" class="form-control" id="tanggal"
                                            @disabled(!request('lapangan_id')) required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Jam</label>
                                        <select name="jam" id="jam" class="form-select" disabled required>
                                            <option selected disabled>Pilih Jam</option>
                                            <option value="00:00">00:00</option>
                                            <option value="01:00">01:00</option>
                                            <option value="02:00">02:00</option>
                                            <option value="03:00">03:00</option>
                                            <option value="04:00">04:00</option>
                                            <option value="05:00">05:00</option>
                                            <option value="06:00">06:00</option>
                                            <option value="07:00">07:00</option>
                                            <option value="08:00">08:00</option>
                                            <option value="09:00">09:00</option>
                                            <option value="10:00">10:00</option>
                                            <option value="11:00">11:00</option>
                                            <option value="12:00">12:00</option>
                                            <option value="13:00">13:00</option>
                                            <option value="14:00">14:00</option>
                                            <option value="15:00">15:00</option>
                                            <option value="16:00">16:00</option>
                                            <option value="17:00">17:00</option>
                                            <option value="18:00">18:00</option>
                                            <option value="19:00">19:00</option>
                                            <option value="20:00">20:00</option>
                                            <option value="21:00">21:00</option>
                                            <option value="22:00">22:00</option>
                                            <option value="23:00">23:00</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Durasi (jam)</label>
                                        <select name="durasi" id="durasi" class="form-select">
                                            <option selected disabled>Pilih Jam</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nominal Booking</label>
                                        <input type="number" name="total_bayar" class="form-control"
                                            id="total_bayar" @disabled(!request('lapangan_id')) required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-dark w-100">Booking</button>
                                </div>
                            </div>
                        </form>

                        <p class="text-secondary text-center mt-5">
                            Thank you very much for doing business with us. We
                            look forward to working with you again!
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
{{-- Vendor --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
    integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script type="text/javascript" src="/datatables/datatables.min.js"></script>
<script src="/tabler-1.2.0/dashboard/libs/tom-select/dist/js/tom-select.complete.min.js"></script>
<script>
    const today = new Date();
    today.setDate(today.getDate() + 1);
    const besok = today.toISOString().split('T')[0];
    const tanggal = document.getElementById("tanggal");
    const jam = document.getElementById("jam");
    const durasi = document.getElementById("durasi");
    const query = new URLSearchParams(window.location.search);
    const lapangan_id = query.get("lapangan_id")
    const harga_lapangan = "{{ $lapangan->harga }}";
    const total_bayar = document.getElementById("total_bayar");
    const saldo = "{{ Auth::user()->saldo }}";

    let available = []; // simpan data jam kosong dari API

    window.addEventListener("DOMContentLoaded", () => {
        flatpickr('#tanggal', {
            minDate: besok
        });
    });

    // Ambil jam kosong dari API saat user pilih tanggal
    tanggal.addEventListener("change", async () => {
        const response = await fetch(`/api/jam/${lapangan_id}/${tanggal.value}`);
        const result = await response.json();

        available = result.payload || [];

        jam.removeAttribute("disabled");

        // filter jam option sesuai data available
        [...jam.options].forEach(option => {
            if (!option.value) return; // skip placeholder
            if (available.includes(option.value)) {
                option.disabled = false;
                option.hidden = false;
            } else {
                option.disabled = true;
                option.hidden = true;
            }
        });

        // reset pilihan
        jam.value = "";
        durasi.value = "";
        durasi.setAttribute("disabled", true);
    });

    // Hitung durasi maksimal dari jam yg dipilih
    jam.addEventListener("change", () => {
        durasi.removeAttribute("disabled");

        const selectedJam = jam.value;
        if (!selectedJam) return;

        // konversi "HH:00" jadi angka jam
        const startHour = parseInt(selectedJam.split(":")[0]);

        let maxDurasi = 0;
        for (let i = 0; i < 24; i++) {
            const checkHour = startHour + i;
            if (checkHour >= 24) break; // stop kalau lewat tengah malam

            const jamString = checkHour.toString().padStart(2, "0") + ":00";
            if (available.includes(jamString)) {
                maxDurasi++;
            } else {
                break; // stop kalau jam berikutnya tidak available
            }
        }

        // reset semua opsi durasi
        [...durasi.options].forEach((option, index) => {
            console.log(option)
            if (index === 0) return; // skip placeholder
            const value = parseInt(option.value);
            if (value <= maxDurasi && value > 0) {
                option.disabled = false;
                option.hidden = false;
            } else {
                option.disabled = true;
                option.hidden = true;
            }
        });

        durasi.value = "";
    });

    durasi.addEventListener("change", () => {
        const hargaPerJam = parseInt(harga_lapangan);
        const totalHarga = durasi.value * hargaPerJam;

        // Kalau saldo sudah cukup untuk menutup semua harga
        if (parseInt(saldo) >= totalHarga) {
            total_bayar.value = 0; // semua dibayar pakai saldo
            total_bayar.placeholder = "Dibayar penuh dengan saldo";

            total_bayar.value = 0; // default minimal
            total_bayar.min = 0;
            total_bayar.max = 0;
        } else {
            const min = (totalHarga / 2) - parseInt(saldo);
            const max = totalHarga - parseInt(saldo);

            // Pastikan tidak negatif
            const minBayar = Math.max(min, (harga_lapangan * durasi.value - saldo) / 2);
            const maxBayar = Math.max(max, (harga_lapangan * durasi.value) - saldo);

            total_bayar.value = minBayar; // default minimal
            total_bayar.placeholder = `${minBayar} - ${maxBayar}`;
            total_bayar.min = minBayar;
            total_bayar.max = maxBayar;
        }
    });


    // Submit booking
    document.getElementById("bookingForm").addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);

        const response = await fetch("/booking/store", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            },
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            if (result.bayarMidtrans > 0) {
                snap.pay(result.snapToken, {
                    onSuccess: () => window.location.href = '/booking',
                    onPending: () => window.location.href = '/booking',
                    onError: () => window.location.href = '/booking',
                    onClose: () => {
                        alert("Anda menutup pembayaran.");
                        window.location.href = '/booking';
                    }
                });
            } else {
                // Semua ditutup saldo
                alert("Booking berhasil dibayar penuh dengan saldo!");
                window.location.href = '/booking';
            }
        }
    });
</script>


</html>
