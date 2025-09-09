<x-dashboard title="{{ $title }}">
    @if (session('roles')->pluck('role')->pluck('role')->contains('Owner'))
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modal-create-turnamen">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-award">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 9m-6 0a6 6 0 1 0 12 0a6 6 0 1 0 -12 0" />
                <path d="M12 15l3.4 5.89l1.598 -3.233l3.598 .232l-3.4 -5.889" />
                <path d="M6.802 12l-3.4 5.89l3.598 -.233l1.598 3.232l3.4 -5.889" />
            </svg>
            Tambah Turnamen
        </button>
    @endif
    @include('turnamen.modal-create')
    <div class="table-responsive">
        <table class="table table-vcenter table-nowrap" id="table-turnamen">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Turnamen</th>
                    <th>Biaya Pendaftaran</th>
                    <th>Foto</th>
                    <th class="w-1">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($turnamen as $index => $turnamen)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $turnamen->nama_turnamen }}</td>
                        <td>Rp. {{ number_format($turnamen->biaya, 0, ',', '.') }}</td>
                        <td>
                            <a href="/banner_turnamen/{{ $turnamen->banner }}" class="btn btn-info btn-icon" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-photo-share">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M15 8h.01" />
                                    <path d="M12 21h-6a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v7" />
                                    <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l3 3" />
                                    <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0" />
                                    <path d="M16 22l5 -5" />
                                    <path d="M21 21.5v-4.5h-4.5" />
                                </svg>
                            </a>
                        </td>
                        <td>
                            <div class="d-inline">
                                <a class="btn btn-dark btn-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-turnamen-edit">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                                        <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" />
                                    </svg>
                                </a>
                                <button class="btn btn-danger btn-icon" data-bs-toggle="modal"
                                    data-bs-target="#delete-turnamen-{{ $turnamen->id }}">
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
                                @include('turnamen.modal-delete')
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        window.addEventListener("DOMContentLoaded", () => {
            new DataTable('#table-turnamen');
        })
    </script>
    <script>
        const input = document.getElementById('file-input');
        const preview = document.getElementById('preview');

        input.addEventListener('change', () => {
            preview.innerHTML = ''; // hapus preview lama

            const file = input.files[0];
            if (!file || !file.type.startsWith('image/')) return;

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.onload = () => URL.revokeObjectURL(img.src);

            preview.appendChild(img);
        });
    </script>
</x-dashboard>
