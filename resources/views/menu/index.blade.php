<x-dashboard title="{{ $title }}">
    <form action="{{ route('menu.update') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pengaturan Menu</h3>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-dark mb-3" onclick="addMenu()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-text-plus">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M19 10h-14" />
                        <path d="M5 6h14" />
                        <path d="M14 14h-9" />
                        <path d="M5 18h6" />
                        <path d="M18 15v6" />
                        <path d="M15 18h6" />
                    </svg>
                    Tambah Menu
                </button>
                <ul id="menu-list" class="list-group list-group-flush sortable-menu">
                    @foreach ($menus as $index => $item)
                        @include('components.menu-item-sortable', ['item' => $item])
                    @endforeach
                    @include('menu.modal-icon')
                </ul>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
            </div>
        </div>
    </form>

    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        let selectedIconInput = null;
        let selectedButton = null;

        // Saat tombol edit icon diklik
        document.querySelectorAll('.btn-select-icon').forEach(btn => {
            btn.addEventListener('click', () => {
                const inputId = btn.dataset.input;
                selectedIconInput = document.getElementById(inputId);
                selectedButton = btn;
            });
        });

        // Saat user memilih icon dari modal
        document.querySelectorAll('.icon-select').forEach(iconBtn => {
            iconBtn.addEventListener('click', () => {
                if (!selectedIconInput || !selectedButton) return;

                const iconSvg = iconBtn.dataset.icon;

                // Set innerHTML agar tombol berubah tampilan
                selectedButton.innerHTML = iconSvg;

                // Set string SVG ke value input hidden (akan disimpan ke DB)
                selectedIconInput.value = iconSvg;

                // Tutup modal
                const modalEl = document.getElementById('icon-picker');
                const modal = tabler.Modal.getInstance(modalEl);
                modal.hide();
            });
        });
    </script>
    <script>
        function updateParentIds() {
            const allItems = document.querySelectorAll('#menu-list li');

            allItems.forEach(li => {
                const parentUl = li.parentElement.closest('li');
                const parentId = parentUl ? parentUl.dataset.id : null;
                const id = li.dataset.id;

                const input = li.querySelector(`input[name="parent[${id}]"]`);
                if (input) {
                    input.value = parentId || '';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const lists = document.querySelectorAll('.sortable-menu');

            lists.forEach(list => {
                new Sortable(list, {
                    group: 'nested',
                    animation: 150,
                    fallbackOnBody: true,
                    swapThreshold: 0.65,
                    handle: '.handle',
                    onEnd: () => updateParentIds() // update parent ID setiap selesai drag
                });
            });

            updateParentIds();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('icon-search-input');

            searchInput.addEventListener('input', function() {
                const keyword = this.value.toLowerCase();
                const buttons = document.querySelectorAll('#icon-picker .icon-select');

                buttons.forEach(button => {
                    const name = button.getAttribute('data-name');
                    const match = name.includes(keyword);
                    button.closest('.col-2').style.display = match ? 'block' : 'none';
                });
            });
        });
    </script>
    <script>
        let tempIdCounter = -1;

        async function addMenu() {
            const menuList = document.getElementById("menu-list");
            const newId = tempIdCounter--;

            const li = document.createElement("li");
            li.className = "list-group-item px-0 border-0";
            li.setAttribute("data-id", newId);

            li.innerHTML = `
                <div class="d-flex align-items-center gap-2">
                    <div class="handle cursor-move me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-grip-vertical">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                            <path d="M9 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                            <path d="M9 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                            <path d="M15 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                            <path d="M15 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                            <path d="M15 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                        </svg>
                    </div>

                    <input type="hidden" name="ids[]" value="${newId}">
                    <input type="hidden" name="parent[${newId}]" value="">

                    <input type="text" name="label[${newId}]" class="form-control me-2" placeholder="Label">
                    <input type="text" name="url[${newId}]" class="form-control me-2" placeholder="URL">

                    <input type="hidden" id="icon-${newId}" name="icon[${newId}]" value="">
                    <button type="button" class="btn btn-icon btn-select-icon" data-input="icon-${newId}" data-bs-toggle="modal" data-bs-target="#icon-picker">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-photo">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M15 8h.01" />
                            <path d="M6 13l2.644 -2.644a2 2 0 0 1 2.828 0l2.644 2.644" />
                            <path d="M12 20h-6a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6" />
                            <path d="M16 19h6" />
                            <path d="M19 16v6" />
                        </svg>
                    </button>

                    <button type="button" class="btn btn-icon btn-danger" onclick="this.closest('li').remove();">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z"/>
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            `;

            // Tambahkan di awal menu list
            menuList.prepend(li);

            // Re-bind tombol icon picker baru
            li.querySelector('.btn-select-icon').addEventListener('click', (e) => {
                selectedIconInput = document.getElementById(e.currentTarget.dataset.input);
                selectedButton = e.currentTarget;
            });

            updateParentIds(); // update parent_id setelah penambahan
        }

        async function deleteMenu(id) {
            const modal = tabler.Modal.getInstance(document.getElementById(`delete-${id}`));
            modal.hide();
            const row = document.querySelector(`[data-id="${id}"]`);
            row.remove();
        }
    </script>
</x-dashboard>
