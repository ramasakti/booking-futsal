<x-dashboard title="{{ $title }}">
    <a href="{{ route('lapangan.create') }}" class="btn btn-dark">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 5l0 14" />
            <path d="M5 12l14 0" />
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-soccer-field">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
            <path d="M3 9h3v6h-3z" />
            <path d="M18 9h3v6h-3z" />
            <path d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
            <path d="M12 5l0 14" />
        </svg>
        Tambah Lapangan
    </a>
    <div class="table-responsive">
        <table class="table table-vcenter table-nowrap" id="table-lapangan">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Lapangan</th>
                    <th>Foto</th>
                    <th>Harga / Jam</th>
                    <th class="w-1">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lapangan as $index => $lapangan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $lapangan->nama_lapangan }}</td>
                        <td>
                            @foreach ($lapangan->foto as $ifoto => $foto)
                                <li>
                                    <a target="_blank" href="{{ $foto->foto }}">Foto {{ $ifoto + 1 }}</a>
                                </li>
                            @endforeach
                        </td>
                        <td>Rp. {{ number_format($lapangan->harga, 0, ',', '.') }}</td>
                        <td>
                            <div class="d-inline">
                                <a class="btn btn-dark btn-icon" href="{{ route('lapangan.edit', $lapangan->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-lapangan-edit">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                                        <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" />
                                    </svg>
                                </a>
                                <button class="btn btn-danger btn-icon" data-bs-toggle="modal"
                                    data-bs-target="#delete-lapangan-{{ $lapangan->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                                @include('lapangan.delete')
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        window.addEventListener("DOMContentLoaded", () => {
            new DataTable('#table-lapangan');
        })
    </script>
</x-dashboard>
