<x-dashboard title="{{ $title }}">
    @if (session('roles')->pluck('role')->pluck('role')->contains('Pelanggan'))
        @include('pelanggan')
    @else
        @include('admin')
    @endif
</x-dashboard>