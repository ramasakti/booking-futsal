<x-dashboard title="{{ $title }}">
    @if (session('roles')->pluck('role')->pluck('role')->contains('Pelanggan'))
        @include('pelanggan')
    @else
        @include('admin')
    @endif

    <script>
        const form = document.getElementById("formTanggal")
        window.addEventListener("DOMContentLoaded", function() {
            // Ambil value dari server (misalnya "2025-09-01 to 2025-09-15")
            const tanggalValue = "{{ request('tanggal') }}";

            // Pecah jadi array (hanya jika ada value)
            const defaultDate = tanggalValue ?
                tanggalValue.split(" to ").map(t => t.trim()) :
                [];

            flatpickr("#tanggal", {
                mode: "range",
                dateFormat: "Y-m-d", // pastikan format sama dengan request()
                defaultDate: defaultDate,
                onChange: function(_, dateStr) {
                    console.log(dateStr)
                    form.submit();
                }
            });
        });
    </script>
</x-dashboard>
