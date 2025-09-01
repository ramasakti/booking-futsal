<x-dashboard title="{{ $title }}">
    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#create-kelas">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 5l0 14" />
            <path d="M5 12l14 0" />
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-door">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M14 12v.01" />
            <path d="M3 21h18" />
            <path d="M6 21v-16a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v16" />
        </svg>
        Tambah Kelas
    </button>
    @include('kelas.modal-create')
    <div class="table-responsive">
        <table class="table table-vcenter table-nowrap" id="table-kelas">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Institusi</th>
                    <th>Kelas</th>
                    <th>Wali Kelas</th>
                    <th class="w-1">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kelas as $index => $kls)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $kls->institusi->institusi }}</td>
                        <td>{{ $kls->nama_kelas }}</td>
                        <td>{{ $kls->walas->name }}</td>
                        <td>
                            <div class="d-inline">
                                <button class="btn btn-icon btn-dark" data-bs-toggle="modal"
                                    data-bs-target="#edit-kelas-{{ $kls->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-adjustments-alt">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 8h4v4h-4z" />
                                        <path d="M6 4l0 4" />
                                        <path d="M6 12l0 8" />
                                        <path d="M10 14h4v4h-4z" />
                                        <path d="M12 4l0 10" />
                                        <path d="M12 18l0 2" />
                                        <path d="M16 5h4v4h-4z" />
                                        <path d="M18 4l0 1" />
                                        <path d="M18 9l0 11" />
                                    </svg>
                                </button>
                                <button class="btn btn-icon btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-kelas-{{ $kls->id }}">
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
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        window.addEventListener("DOMContentLoaded", () => {
            new DataTable('#table-kelas')
            new TomSelect("#select-institusi", {
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
            new TomSelect("#select-walas", {
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        })
    </script>
</x-dashboard>
