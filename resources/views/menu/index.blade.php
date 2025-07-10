<x-dashboard title="{{ $title }}">
    <form action="{{ route('menu.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pengaturan Menu</h3>
            </div>
            <div class="card-body">
                <ul id="menu-list" class="list-group list-group-flush sortable-menu">
                    @foreach ($menus as $item)
                        @include('components.menu-item-sortable', ['item' => $item])
                    @endforeach
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
</x-dashboard>
