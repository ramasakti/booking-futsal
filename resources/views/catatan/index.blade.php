<x-dashboard title="{{ $title }}">
    <form method="get">
        <label class="form-label">Kelas</label>
        <select name="kelas" class="form-control" onchange="this.form.submit()" >
            <option selected disabled>Pilih Kelas</option>
            @foreach ($kelas as $kls)
                <option value="{{ $kls->id }}" @selected($kls->id == request('kelas'))>{{ $kls->nama_kelas }}</option>
            @endforeach
        </select>
    </form>

    <div class="row">
        
    </div>
</x-dashboard>
