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
                    <th>Foto</th>
                    <th>Harga / Jam</th>
                    <th class="w-1">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($turnamen as $index => $turnamen)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $turnamen->nama_turnamen }}</td>
                        <td>
                            @foreach ($turnamen->foto as $ifoto => $foto)
                                <li>
                                    <a target="_blank" href="{{ $foto->foto }}">Foto {{ $ifoto + 1 }}</a>
                                </li>
                            @endforeach
                        </td>
                        <td>Rp. {{ number_format($turnamen->harga, 0, ',', '.') }}</td>
                        <td>
                            <div class="d-inline">
                                <a class="btn btn-dark btn-icon" href="{{ route('turnamen.edit', $turnamen->id) }}">
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
                                @include('turnamen.delete')
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

        let filesArray = []; // simpan file yang dipilih

        input.addEventListener('change', () => {
            filesArray = [...filesArray, ...Array.from(input.files)];
            renderPreviews();
        });

        function renderPreviews() {
            preview.innerHTML = '';
            filesArray.forEach((file, index) => {
                if (!file.type.startsWith('image/')) return;
                const item = document.createElement('div');
                item.className = 'preview-item';

                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.onload = () => URL.revokeObjectURL(img.src);

                const btn = document.createElement('button');
                btn.className = 'remove-btn';
                btn.innerHTML = '❌';
                btn.onclick = () => {
                    filesArray.splice(index, 1);
                    renderPreviews();
                };

                item.appendChild(img);
                item.appendChild(btn);
                preview.appendChild(item);
            });
        }
    </script>
</x-dashboard>
