<!DOCTYPE html>
<html lang="id" style="margin-left: 0;">

<head>
    <meta charset="UTF-8">
    <title>Futsal Srikandi - Booking Lapangan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="index.css">
    <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <link href="/tabler-1.2.0/dashboard/dist/css/tabler.css" rel="stylesheet" />
    <style>
        /* Kalender inline full width */
        .flatpickr-calendar.inline {
            width: 100% !important;
            max-width: 100% !important;
            border: 1px solid #ddd;
            box-shadow: none;
        }

        /* Biar container ikut melebar */
        .flatpickr-days,
        .dayContainer {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            justify-content: space-between !important;
            display: flex !important;
            flex-wrap: wrap !important;
        }

        /* Bagi cell ke 7 kolom */
        .flatpickr-day {
            flex: 1 0 calc(100% / 7);
            /* bagi rata jadi 7 */
            max-width: calc(100% / 7);
            height: 50px;
            /* tinggi cell */
            line-height: 50px;
            /* teks center */
            font-size: 18px;
            /* perbesar teks */
            margin: 0 !important;
            /* hilangkan margin default */
            box-sizing: border-box;
        }

        .flatpickr-innerContainer,
        .flatpickr-rContainer,
        .flatpickr-days {
            width: 100% !important;
        }

        .flatpickr-months .flatpickr-month {
            background: transparent;
            color: rgba(0, 0, 0, 0.9);
            fill: rgba(0, 0, 0, 0.9);
            height: 60px;
            line-height: 1;
            text-align: center;
            position: relative;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            overflow: hidden;
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            -ms-flex: 1;
            flex: 1;
            font-size: 18px;
        }

        html {
            margin-left: 0;
        }
    </style>
</head>

<body>
    <header>
        <img src="/images/logo.jpeg" style="max-height: 100px; border-radius: 50%;">
        <h2>Futsal Srikandi Lampung</h2>
    </header>
    <div class="container">
        <section class="hero">
            <div class="hero-text">
                <h1>Booking Lapangan Futsal Terbaik</h1>
                <p>
                    Nikmati kemudahan dalam memesan lapangan futsal berkualitas tinggi. Praktis, cepat, dan terpercaya
                    untuk semua kebutuhan olahraga Anda.
                </p>

                <div class="button-group">
                    <a href="{{ route('register') }}" class="btn text-white">Register Sekarang</a>
                    <a href="{{ route('login') }}" class="btn secondary text-white">Login & Booking</a>
                </div>
            </div>

            <div class="hero-image"></div>
        </section>

        <section class="kalender">
            <div class="row">
                <div class="col-12">
                    <select name="lapangan_id" id="lapangan_id" class="form-select">
                        <option value="0">Semua Lapangan</option>
                        @foreach ($lapangan as $lap)
                            <option value="{{ $lap->id }}">{{ $lap->nama_lapangan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div id="kalender"></div>
        </section>

        <!-- Courts Section -->
        <section class="courts-section">
            <div class="section-title">
                <h2>Pilih Lapangan Favorit Anda</h2>
                <p>
                    Lapangan berkualitas premium dengan fasilitas terbaik untuk pengalaman bermain yang tak terlupakan
                </p>
            </div>

            @if (!empty($lapangan))
                @foreach ($lapangan as $lapangan)
                    <div class="courts-grid">
                        <div class="court-card">
                            <div class="court-image">
                                <div class="image-slider">
                                    <div class="slider-container">
                                        @if (!empty($lapangan->foto))
                                            @foreach ($lapangan->foto as $foto)
                                                <div class="slide">
                                                    <img src="{{ $foto->foto }}"
                                                        style="width:100%; height:100%; object-fit:cover;">
                                                </div>
                                            @endforeach
                                        @else
                                            <!-- Jika tidak ada foto, tetap tampilkan overlay -->
                                            <div class="slide">
                                                <div class="slide-overlay"></div>
                                            </div>
                                            <div class="slide">
                                                <div class="slide-overlay"></div>
                                            </div>
                                            <div class="slide">
                                                <div class="slide-overlay"></div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="slider-dots">
                                        @if (!empty($lapangan->foto))
                                            @foreach ($lapangan->foto as $dot)
                                                <div class="dot"></div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="court-info">
                                <h3 class="court-name">{{ $lapangan->nama_lapangan }}</h3>
                                <div class="court-price">
                                    <div>
                                        <span class="price">
                                            Rp {{ number_format($lapangan->harga, 0, ',', '.') }}
                                        </span>
                                        <span class="price-per">/jam</span>
                                    </div>
                                </div>
                                <a class="book-btn" style="text-decoration: none;" href="{{ route('booking.index') }}">
                                    Booking Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </section>

        <section class="courts-section">
            <div class="section-title">
                <h2>Turnamen</h2>
                <p>
                    Lapangan berkualitas premium dengan fasilitas terbaik untuk pengalaman bermain yang tak terlupakan
                </p>
            </div>

            @if (!empty($turnamens))
                @foreach ($turnamens as $turnamen)
                    <div class="courts-grid">
                        <div class="court-card">
                            <div class="court-image">
                                <div class="image-slider">
                                    <div class="slider-container">
                                        <div>
                                            <img src="/banner_turnamen/{{ $turnamen->banner }}"
                                                style="width:100%; height:100%; object-fit:cover;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="court-info">
                                <h3 class="court-name">{{ $turnamen->nama_turnamen }}</h3>
                                <div class="court-price">
                                    <div>
                                        <span class="price">
                                            Rp {{ number_format($turnamen->biaya, 0, ',', '.') }}
                                        </span>
                                        <span class="price-per">/tim</span>
                                    </div>
                                </div>
                                {{-- <a class="book-btn" style="text-decoration: none;"
                                    href="{{ route('booking.index') }}">
                                    Daftar Sekarang
                                </a> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </section>
    </div>

    {{-- Modal --}}
    <div class="modal" id="modalJadwal" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Jadwal Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-vcenter table-nowrap" id="table-lapangan">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Lapangan</th>
                                    <th>Jam</th>
                                    <th>Pemesan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/tabler-1.2.0/dashboard/libs/apexcharts/dist/apexcharts.min.js" defer></script>
<script src="/tabler-1.2.0/dashboard/libs/jsvectormap/dist/jsvectormap.min.js" defer></script>
<script src="/tabler-1.2.0/dashboard/libs/jsvectormap/dist/maps/world.js" defer></script>
<script src="/tabler-1.2.0/dashboard/libs/jsvectormap/dist/maps/world-merc.js" defer></script>
<script src="/tabler-1.2.0/dashboard/dist/js/tabler.min.js" defer></script>
<script>
    window.addEventListener("DOMContentLoaded", () => {
        const modalJadwal = new tabler.Modal(document.getElementById('modalJadwal'))
        const modalTitle = document.getElementById("modal-title")
        const lapangan = document.getElementById("lapangan_id")
        flatpickr('#kalender', {
            locale: "id",
            dateFormat: "Y-m-d",
            inline: true,
            onChange: async (selectedDates, dateStr) => {
                modalTitle.innerHTML = `Jadwal Booking ${dateStr}`

                const url = `/api/jadwal?tanggal=${dateStr}` + (lapangan.value ?
                    `&lapangan_id=${lapangan.value}` : '')
                console.log(url)

                try {
                    const response = await fetch(url)
                    const result = await response.json()

                    if (result.success && result.payload) {
                        const tbody = document.querySelector("#table-lapangan tbody")
                        tbody.innerHTML = "" // kosongkan dulu

                        result.payload.forEach((item, index) => {
                            // ambil jam_mulai
                            const [h, m, s] = item.jam_mulai.split(":").map(Number)
                            const start = new Date()
                            start.setHours(h, m, s)

                            // hitung jam selesai
                            const end = new Date(start)
                            end.setHours(start.getHours() + item.durasi_jam)

                            // format ke HH.mm
                            const formatTime = (date) => {
                                const hh = String(date.getHours()).padStart(2, "0")
                                const mm = String(date.getMinutes()).padStart(2, "0")
                                return `${hh}.${mm}`
                            }

                            const jamDisplay = `${formatTime(start)} - ${formatTime(end)}`

                            // render ke tabel
                            const tr = document.createElement("tr")
                            tr.innerHTML = `
                                <td>${index + 1}</td>
                                <td>${item.nama_lapangan}</td>
                                <td>${jamDisplay}</td>
                                <td>${item.booking_name}</td>
                            `
                            tbody.appendChild(tr)
                        })

                    }
                    openModal()
                } catch (err) {
                    console.error("Gagal ambil data:", err)
                }
            }

        });
        const openModal = () => modalJadwal.show()
        const closeModal = () => modalJadwal.close()
    });
</script>

</html>
