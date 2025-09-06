<div class="modal" id="modal-create-turnamen" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Turnamen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Nama Turnamen</label>
                            <input type="text" name="nama_turnamen" class="form-control" placeholder="Nama Turnamen">
                        </div>
                    </div>
                    <label class="dropzone">
                        <input id="file-input" type="file" name="foto[]" accept="image/*">
                        <div class="dropzone-content">
                            <strong>Tarik & letakkan gambar di sini</strong><br>
                            <span>atau</span><br>
                            <span class="btn">Pilih Gambar</span>
                        </div>
                    </label>
                    <div id="preview" class="preview-grid-single"></div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" cols="30" rows="5" placeholder="Deskripsi Turnamen"></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Biaya Pendaftaran</label>
                            <input type="text" name="biaya" class="form-control" placeholder="Biaya Pendaftaran">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M14 4l0 4l-6 0l0 -4" />
                    </svg>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>
