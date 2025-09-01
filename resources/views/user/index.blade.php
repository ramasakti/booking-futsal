<x-dashboard title="{{ $title }}">
    <button class="btn btn-dark mb-3" data-bs-toggle="modal" data-bs-target="#create-user">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
            <path d="M16 19h6" />
            <path d="M19 16v6" />
            <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
        </svg>
        Tambah User
    </button>
    @include('user.modal-create')

    <div class="table-responsive">
        <table class="table table-vcenter table-nowrap" id="table-user">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Institusi</th>
                    <th>Role</th>
                    <th class="w-1">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->userInstitusi->pluck('institusi')->pluck('institusi')->implode(', ') }}</td>
                        <td>{{ $user->userRole->pluck('role')->pluck('role')->implode(', ') }}</td>
                        <td>
                            <div class="d-inline">
                                <button class="btn btn-dark btn-icon" data-bs-toggle="modal" data-bs-target="#edit-user-{{ $user->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-edit">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                                        <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" />
                                    </svg>
                                </button>
                                @include('user.modal-edit')
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        window.addEventListener("DOMContentLoaded", () => {
            new DataTable('#table-user');
        })
    </script>
</x-dashboard>
