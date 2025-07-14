<!-- Modal Icon Picker -->
<div class="modal" id="icon-picker" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Icon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="input-icon mb-3">
                        <input type="text" id="icon-search-input" value="" class="form-control" placeholder="Search…" />
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="10" cy="10" r="7" />
                                <line x1="21" y1="21" x2="15" y2="15" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="row row-cards">
                    @foreach (File::files(public_path('tabler-icons/outline')) as $file)
                        @php
                            $iconName = $file->getFilename();
                            $iconContent = file_get_contents($file);
                            $iconNameClean = pathinfo($iconName, PATHINFO_FILENAME);
                        @endphp
                        <div class="col-2 mb-3 text-center">
                            <button type="button" class="btn btn-light w-100 icon-select"
                                data-icon="{{ $iconContent }}" data-name="{{ strtolower($iconNameClean) }}">
                                {!! $iconContent !!}
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
