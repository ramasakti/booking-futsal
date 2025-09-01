<div class="modal" id="create-user" tabindex="-1">
    <div class="modal-dialog" role="document">
        <form action="{{ route('user.store') }}" method="post">
            @csrf 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role_id" class="form-select" multiple required>
                            <option selected disabled>Pilih Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Institusi</label>
                        <select name="institusi_id" class="form-select" required>
                            <option selected disabled>Pilih Institusi</option>
                            @foreach ($institusies as $institusi)
                                <option value="{{ $institusi->id }}">{{ $institusi->institusi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark" data-bs-dismiss="modal">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
