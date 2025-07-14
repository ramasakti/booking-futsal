<div class="modal" id="edit-role-{{ $role->id }}" tabindex="-1">
    <div class="modal-dialog" role="document">
        <form action="{{ route('role.update', $role->id) }}" method="post">
            @method("PUT")
            @csrf 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Role</label>
                    <input type="text" name="role" class="form-control" value="{{ $role->role }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark" data-bs-dismiss="modal">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
