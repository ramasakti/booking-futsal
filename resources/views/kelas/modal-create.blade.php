<div class="modal" id="create-kelas" tabindex="-1">
    <div class="modal-dialog" role="document">
        <form action="{{ route('kelas.store') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Institusi</label>
                        <select name="institusi_id" id="select-institusi" placeholder="Pilih Institusi">
                            <option selected disabled></option>
                            @foreach ($institusies as $institusi)
                                <option value="{{ $institusi->id }}">
                                    {{ $institusi->institusi->institusi ?? $institusi->institusi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenjang</label>
                        <input type="text" name="jenjang" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Wali Kelas</label>
                        <select name="walas_id" id="select-walas" placeholder="Pilih Wali Kelas">
                            <option selected disabled></option>
                            @foreach ($walas as $walas)
                                <option value="{{ $walas->id }}">
                                    {{ $walas->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark" data-bs-dismiss="modal">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
