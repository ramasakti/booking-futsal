<x-dashboard title="{{ $title }}">
    @if (session('roles')->pluck('role')->pluck('role')->contains('Pelanggan'))
        <a href="{{ route('booking.booking') }}" class="btn btn-teal">
            Booking Sekarang!
        </a>
    @endif
    <div class="table-responsive">
        <table class="table table-vcenter table-nowrap" id="table-bookings">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Lapangan</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Status</th>
                    <th class="w-1">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $index => $booking)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $booking->lapangan->nama_lapangan }}</td>
                        <td>{{ $booking->tanggal }}</td>
                        <td>{{ $booking->jam_mulai }}</td>
                        <td>{{ $booking->status }}</td>
                        <td>
                            <div class="d-inline">

                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        window.addEventListener("DOMContentLoaded", () => {
            new DataTable('#table-bookings');
        })
    </script>
</x-dashboard>
