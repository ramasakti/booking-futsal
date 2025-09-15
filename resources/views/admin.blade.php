<div class="row g-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Profil</h3>
                <div class="card-actions">
                    <a href="{{ route('user.edit', Auth::user()->username) }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-edit">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                            <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" />
                        </svg>
                        Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Total Booking</div>
                </div>
                <div class="h1 text-primary">{{ $bookings->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Cancel</div>
                </div>
                <div class="h1 text-danger">{{ $bookings->where('status', 'cancel')->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Success</div>
                </div>
                <div class="h1 text-teal">{{ $bookings->where('status', 'success')->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Pending</div>
                </div>
                <div class="h1 text-warning">{{ $bookings->where('status', 'pending_accept')->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Omset Hari Ini</div>
                </div>
                <div class="h1 text-dark">
                    Rp.
                    {{ number_format($bookings->where('status', 'success')->where('tanggal', date('Y-m-d'))->sum('total_harga'), 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Omset Bulan Ini</div>
                </div>
                <div class="h1 text-dark">
                    @php
                        $bulanan = $bookings->filter(function ($item) {
                            return \Carbon\Carbon::parse($item['tanggal'])->month == date('m');
                        });
                        $bulanan = $bulanan->where('status', 'success');
                    @endphp
                    Rp.
                    {{ number_format($bulanan->sum('total_harga'), 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Omset Tahun Ini</div>
                </div>
                <div class="h1 text-dark">
                    @php
                        $tahunan = $bookings->filter(function ($item) {
                            return \Carbon\Carbon::parse($item['tanggal'])->year == date('Y');
                        });
                        $tahunan = $tahunan->where('status', 'success');
                    @endphp
                    Rp.
                    {{ number_format($tahunan->sum('total_harga'), 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Download Excel Laporan Keuangan</h3>
                <form action="" method="get" id="formTanggal">
                    <input type="text" name="tanggal" class="form-control ms-3" id="tanggal"
                        placeholder="Range Tanggal">
                </form>
                <div class="card-actions">
                    <a href="{{ route('booking.export', ['tanggal' => request('tanggal')]) }}" class="btn btn-green">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-xls">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                            <path d="M4 15l4 6" />
                            <path d="M4 21l4 -6" />
                            <path
                                d="M17 20.25c0 .414 .336 .75 .75 .75h1.25a1 1 0 0 0 1 -1v-1a1 1 0 0 0 -1 -1h-1a1 1 0 0 1 -1 -1v-1a1 1 0 0 1 1 -1h1.25a.75 .75 0 0 1 .75 .75" />
                            <path d="M11 15v6h3" />
                        </svg>
                        Download
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
