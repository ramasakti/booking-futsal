<div class="modal" id="create-institusi" tabindex="-1">
    <div class="modal-dialog" role="document">
        <form action="{{ route('institusi.store') }}" method="post">
            @csrf 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Institusi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Institusi</label>
                    <input type="text" name="institusi" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark" data-bs-dismiss="modal">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
