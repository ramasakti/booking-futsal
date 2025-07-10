<li class="list-group-item px-0 border-0" data-id="{{ $item->id }}">
    <div class="d-flex align-items-center gap-2">
        <div class="handle cursor-move me-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
        <input type="hidden" name="ids[]" value="{{ $item->id }}">
        <input type="hidden" name="parent[{{ $item->id }}]" value="{{ $item->parent_id }}">

        <input type="text" name="label[{{ $item->id }}]" value="{{ $item->label }}" class="form-control me-2"
            placeholder="Label">

        <input type="text" name="url[{{ $item->id }}]" value="{{ $item->url }}" class="form-control me-2"
            placeholder="URL">

        <input type="text" name="icon[{{ $item->id }}]" value="{{ $item->icon }}" class="form-control"
            placeholder="Icon SVG atau nama">
    </div>

    @if ($item->children->count())
        <ul class="list-group sortable-menu mt-2 ms-4">
            @foreach ($item->children as $child)
                @include('components.menu-item-sortable', ['item' => $child])
            @endforeach
        </ul>
    @endif
</li>
