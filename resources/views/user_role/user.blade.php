<x-dashboard title="{{ $title }}">
    <div class="table-responsive">
        <table class="table table-vcenter table-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Role</th>
                    <th class="w-1">Akses</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $index => $role)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $role->role }}</td>
                        <td>
                            <input type="checkbox" name="role[]" class="form-check-input" value="{{ $role->id }}"
                                @checked($userRoles->contains($role->id)) onchange="userRole(this)" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        async function userRole(role) {
            const response = await fetch('/api/user/role', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    user_id: "{{ request('id_user') }}",
                    role_id: role.value,
                    action: role.checked ? "give" : "drop"
                })
            })
            const data = await response.json()
        }
    </script>
</x-dashboard>
