<x-dashboard title="{{ $title }}">
    @include('components.back')
    <div class="row">
        <form id="myForm" action="{{ route('lapangan.update', $lapangan->id) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <div class="col-12">
                    <label class="form-label">Nama Lapangan</label>
                    <input type="text" name="nama_lapangan" class="form-control" placeholder="Nama Lapangan"
                        value="{{ $lapangan->nama_lapangan }}">
                </div>
            </div>
            <div class="mb-3">
                <div class="col-12">
                    <label class="form-label">Harga</label>
                    <input type="text" name="harga" id="harga" class="form-control"
                        placeholder="Harga Lapangan / Jam" value="{{ $lapangan->harga }}">
                </div>
            </div>
            <label class="dropzone">
                <input id="file-input" type="file" name="foto[]" accept="image/*" multiple>
                <div class="dropzone-content">
                    <strong>Tarik & letakkan gambar di sini</strong><br>
                    <span>atau</span><br>
                    <span class="btn">Pilih gambar</span>
                </div>
            </label>

            <div id="preview-old" class="preview-grid">
                @foreach ($lapangan->foto as $foto)
                    <div class="preview-item">
                        <img src="/{{ $foto->foto }}">
                        <button class="remove-btn" type="button" data-id="{{ $foto->id }}">❌</button>
                    </div>
                @endforeach
            </div>
            <div id="preview-new" class="preview-grid"></div>

            <div class="mb-3">
                <button type="submit" class="btn btn-dark w-100">
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
        </form>
    </div>

    @include('components.rupiah')
    <script>
        const input = document.getElementById('file-input');
        const previewNew = document.getElementById('preview-new'); // untuk foto baru
        const harga = document.getElementById('harga');

        let filesArray = []; // simpan file yang dipilih

        input.addEventListener('change', () => {
            filesArray = [...filesArray, ...Array.from(input.files)];
            renderPreviews();
        });

        harga.addEventListener('input', function(e) {
            this.value = formatRupiah(this.value);
        });

        function renderPreviews() {
            previewNew.innerHTML = '';
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
                previewNew.appendChild(item);
            });
        }

        window.addEventListener("DOMContentLoaded", () => harga.value = formatRupiah("{{ $lapangan->harga }}"))

        document.addEventListener("click", function(e) {
            if (e.target.classList.contains("remove-btn") && e.target.dataset.id) {
                const fotoId = e.target.dataset.id;

                if (confirm("Hapus foto ini?")) {
                    // tambahkan input hidden ke form utama
                    let form = document.getElementById("myForm");
                    let hidden = document.createElement("input");
                    hidden.type = "hidden";
                    hidden.name = "hapus_foto[]"; // array biar bisa banyak
                    hidden.value = fotoId;
                    form.appendChild(hidden);

                    // sembunyikan preview dari UI
                    e.target.parentElement.remove();
                }
            }
        });
    </script>
</x-dashboard>
