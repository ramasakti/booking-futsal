<x-dashboard title="{{ $title }}">
    @include('access.menu-list', [
        'menus' => $menus,
        'checkedMenuIds' => $checkedMenuIds,
    ])
    <script>
        async function accessRole(menu) {
            const response = await fetch('/api/access/role', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    role_id: "{{ request('id_role') }}",
                    menu_id: menu.value,
                    action: menu.checked ? "give" : "drop"
                })
            })
            const data = await response.json()
        }
    </script>
</x-dashboard>
