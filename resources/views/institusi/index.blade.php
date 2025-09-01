<x-dashboard title="{{ $title }}">
    <div class="table-responsive">
        <button class="btn btn-dark mb-3" data-bs-toggle="modal" data-bs-target="#create-institusi">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-building-plus">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M3 21h9" />
                <path d="M9 8h1" />
                <path d="M9 12h1" />
                <path d="M9 16h1" />
                <path d="M14 8h1" />
                <path d="M14 12h1" />
                <path
                    d="M5 21v-16c0 -.53 .211 -1.039 .586 -1.414c.375 -.375 .884 -.586 1.414 -.586h10c.53 0 1.039 .211 1.414 .586c.375 .375 .586 .884 .586 1.414v7" />
                <path d="M16 19h6" />
                <path d="M19 16v6" />
            </svg>
            Tambah Institusi
        </button>
        @include('institusi.modal-create')

        <table class="table table-vcenter table-nowrap" id="table-institusi">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Institusi</th>
                    <th class="w-1">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($institusi as $index => $ins)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $ins->institusi }}</td>
                        <td>
                            <div class="d-inline">
                                <button class="btn btn-icon btn-dark" data-bs-toggle="modal"
                                    data-bs-target="#edit-institusi-{{ $ins->id }}">
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
                                @include('institusi.modal-edit')
                                <button class="btn btn-icon btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-institusi-{{ $ins->id }}">
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
                                @include('institusi.modal-delete')
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        window.addEventListener("DOMContentLoaded", () => {
            new DataTable('#table-institusi');
        })
    </script>
</x-dashboard>
