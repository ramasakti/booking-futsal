<div class="row g-2">
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
</div>
