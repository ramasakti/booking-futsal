<x-dashboard title="{{ $title }}">
    <div class="row">
        <form action="{{ route('user.change', $user->username) }}" method="post" enctype="multipart/form-data">
            <div class="col-12">
                <div class="mb-3">
                    <img id="preview-edit-avatar-{{ $user->id }}"
                        class="avatar-preview mt-2 rounded-circle {{ $user->avatar ? '' : 'd-none' }}"
                        src="{{ $user->avatar ? '/avatar/' . $user->avatar : '' }}">
    
                    @if (!$user->avatar)
                        <div id="avatar-initials-{{ $user->id }}"
                            class="avatar-preview rounded-circle d-flex align-items-center justify-content-center bg-secondary text-white">
                            @php
                                $nama = explode(' ', Auth::user()->name);
                                $inisial = '';
                                foreach ($nama as $n) {
                                    if (!empty($n)) {
                                        $inisial .= strtoupper($n[0]);
                                    }
                                }
                            @endphp
                            {{ $inisial }}
                        </div>
                    @endif
                </div>
            </div>
    
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Avatar</label>
                    <input type="file" name="avatar" accept="image/*" class="form-control edit-avatar"
                        data-preview="preview-edit-avatar-{{ $user->id }}"
                        data-initials="avatar-initials-{{ $user->id }}">
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <button type="submit" class="btn btn-dark w-100">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <style>
        .avatar-preview {
            width: 100px;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            display: inline-block;
        }
    </style>

    <script>
        document.querySelectorAll('.edit-avatar').forEach(input => {
            input.addEventListener('change', function() {
                const preview = document.getElementById(this.dataset.preview);
                const initials = document.getElementById(this.dataset.initials);

                if (this.files && this.files[0]) {
                    preview.src = URL.createObjectURL(this.files[0]);
                    preview.classList.remove('d-none');
                    if (initials) initials.classList.add('d-none');
                } else {
                    preview.src = '';
                    preview.classList.add('d-none');
                    if (initials) initials.classList.remove('d-none');
                }
            });
        });
    </script>
</x-dashboard>
