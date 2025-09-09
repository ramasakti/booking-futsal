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
                    <th>Pemesan</th>
                    <th>Hari</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Status</th>
                    <th>Booking</th>
                    <th>Tunai</th>
                    <th class="w-1">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $index => $booking)
                    <tr tr data-order-id="{{ $booking->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $booking->lapangan->nama_lapangan }}</td>
                        <td>{{ $booking->pemesan->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('l') }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('j F Y') }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H.i') }} -
                            {{ \Carbon\Carbon::parse($booking->jam_mulai)->addHours($booking->durasi_jam)->format('H.i') }}
                        </td>
                        <td>
                            @switch($booking->status)
                                @case('success')
                                    <span class="status status-teal">
                                        <span class="status-dot status-dot-animated"></span>
                                        Success
                                    </span>
                                @break

                                @case('paid')
                                    <span class="status status-green">
                                        <span class="status-dot status-dot-animated"></span>
                                        Paid
                                    </span>
                                @break

                                @case('pending_payment')
                                    <span class="status status-warning">
                                        <span class="status-dot status-dot-animated"></span>
                                        Pending Payment
                                    </span>
                                @break

                                @default
                                    <span class="status status-danger">
                                        <span class="status-dot status-dot-animated"></span>
                                        Cancel / Ditolak
                                    </span>
                            @endswitch
                        </td>
                        <td>Rp. {{ number_format($booking->total_bayar, 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($booking->total_harga - $booking->total_bayar, 0, ',', '.') }}</td>
                        <td>
                            <div class="d-inline">
                                @if (session('roles')->pluck('role')->pluck('role')->contains('Pelanggan'))
                                    @if ($booking->status == 'pending_payment')
                                        <button class="btn btn-icon btn-teal" onclick="bayar('{{ $booking->token }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-credit-card-pay">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M12 19h-6a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4.5" />
                                                <path d="M3 10h18" />
                                                <path d="M16 19h6" />
                                                <path d="M19 16l3 3l-3 3" />
                                                <path d="M7.005 15h.005" />
                                                <path d="M11 15h2" />
                                            </svg>
                                        </button>
                                    @endif
                                    @if ($booking->status !== 'success' && $booking->status !== 'cancel')
                                        <button class="btn btn-icon btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#modal-cancel-{{ $booking->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-x">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M13 21h-7a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6.5" />
                                                <path d="M16 3v4" />
                                                <path d="M8 3v4" />
                                                <path d="M4 11h16" />
                                                <path d="M22 22l-5 -5" />
                                                <path d="M17 22l5 -5" />
                                            </svg>
                                        </button>
                                        @include('booking.modal-cancel')
                                    @endif
                                    @if ($booking->status === 'success')
                                        <a href="" class="btn btn-icon btn-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-invoice">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                <path
                                                    d="M19 12v7a1.78 1.78 0 0 1 -3.1 1.4a1.65 1.65 0 0 0 -2.6 0a1.65 1.65 0 0 1 -2.6 0a1.65 1.65 0 0 0 -2.6 0a1.78 1.78 0 0 1 -3.1 -1.4v-14a2 2 0 0 1 2 -2h7l5 5v4.25" />
                                            </svg>
                                        </a>
                                    @endif
                                @else
                                    @if ($booking->status == 'paid')
                                        <button class="btn btn-icon btn-teal" data-bs-toggle="modal"
                                            data-bs-target="#modal-accept-{{ $booking->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                <path d="M9 12l2 2l4 -4" />
                                            </svg>
                                        </button>
                                        @include('booking.modal-accept')
                                        <button class="btn btn-icon btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#modal-cancel-{{ $booking->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-x">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M13 21h-7a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6.5" />
                                                <path d="M16 3v4" />
                                                <path d="M8 3v4" />
                                                <path d="M4 11h16" />
                                                <path d="M22 22l-5 -5" />
                                                <path d="M17 22l5 -5" />
                                            </svg>
                                        </button>
                                        @include('booking.modal-cancel')
                                    @endif
                                @endif
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

        const bayar = (token) => {
            snap.pay(token, {
                onSuccess: function(result) {
                    console.log("Pembayaran sukses:", result);
                    // misalnya refresh tabel
                    checkPaymentStatus();
                },
                onPending: function(result) {
                    console.log("Pembayaran pending:", result);
                },
                onError: function(result) {
                    console.error("Pembayaran gagal:", result);
                },
                onClose: function() {
                    console.log("Dialog pembayaran ditutup tanpa transaksi");
                    // Jangan redirect apa-apa di sini, cukup biarkan kosong
                }
            });
        }

        // Fungsi untuk cek status pembayaran
        const checkPaymentStatus = async () => {
            document.querySelectorAll('#table-bookings tbody tr').forEach(async (row) => {
                const orderId = row.getAttribute('data-order-id');
                if (!orderId) return;

                const statusTd = row.querySelector('td:nth-child(7)');
                const currentStatus = statusTd.textContent.trim();

                // Hanya cek jika status saat ini "Pending Payment"
                if (!currentStatus.includes('Pending')) return;

                try {
                    const response = await fetch(`/booking/status/${orderId}`);
                    const result = await response.json();

                    if (result.success) {
                        const status = result.payload.transaction_status;

                        if (status === 'settlement') {
                            statusTd.innerHTML = `<span class="status status-green">
                                <span class="status-dot status-dot-animated"></span> Paid
                            </span>`;
                        } else if (status === 'pending') {
                            statusTd.innerHTML = `<span class="status status-warning">
                                <span class="status-dot status-dot-animated"></span> Pending Payment
                            </span>`;
                        } else if (status === 'cancel' || status === 'deny' || status === 'expire') {
                            statusTd.innerHTML = `<span class="status status-danger">
                                <span class="status-dot status-dot-animated"></span> Cancel / Ditolak
                            </span>`;
                        }
                    }
                } catch (error) {
                    console.error('Gagal cek status:', error);
                }
            });
        }

        // Interval setiap 10 detik
        setInterval(checkPaymentStatus, 10000);
    </script>
</x-dashboard>
