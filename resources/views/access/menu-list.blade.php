<ul>
    @foreach ($menus as $menu)
        <li>
            <label class="form-check">
                <input class="form-check-input" type="checkbox" name="menu[]" value="{{ $menu->id }}"
                    @checked(in_array($menu->id, $checkedMenuIds)) onchange="accessRole(this)">
                <span class="form-check-label">{{ $menu->label }}</span>
            </label>

            {{-- Render anak-anaknya jika ada --}}
            @if ($menu->children && $menu->children->count())
                @include('access.menu-list', [
                    'menus' => $menu->children,
                    'checkedMenuIds' => $checkedMenuIds,
                ])
            @endif
        </li>
    @endforeach
</ul>
