<div class="modal" id="edit-user-{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog" role="document">
        <form action="{{ route('user.update', $user->id) }}" method="post">
            @csrf 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="{{ $user->username }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role_id" class="form-select tom-select" required>
                            <option selected disabled>Pilih Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" @selected($user->userRole->pluck('id')->contains($role->id))>
                                    {{ $role->role }}
                                </option>
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
