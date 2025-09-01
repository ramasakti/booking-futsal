<x-dashboard title="{{ $title }}">
    @include('components.back')
    <div class="table-responsive">
        <table class="table table-vcenter table-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Institusi</th>
                    <th class="w-1">Akses</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($institusies as $index => $institusi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $institusi->institusi }}</td>
                        <td>
                            <input type="checkbox" name="institusi[]" class="form-check-input" value="{{ $institusi->id }}"
                                @checked($userInstitusies->contains($institusi->id)) onchange="userInstitusi(this)" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        async function userInstitusi(institusi) {
            const response = await fetch('/api/user/institusi', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    user_id: "{{ request('id_user') }}",
                    institusi_id: institusi.value,
                    action: institusi.checked ? "give" : "drop"
                })
            })
            const data = await response.json()
        }
    </script>
</x-dashboard>
