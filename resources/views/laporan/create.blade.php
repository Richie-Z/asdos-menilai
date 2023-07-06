@extends('layout.index')
@section('judul', 'Tambah Laporan')
@section('content')
    <h1>Tambah Laporan</h1>
    <div>
        <form action="{{ route('laporan.store') }}" method="POST">
            @csrf
            <div>
                <label for="nama">Nama</label><br>
                <input type="text" name="nama">
            </div>
            <div>
                <label for="jumlah_soal">Jumlah Soal</label><br>
                <input type="number" name="jumlah_soal">
            </div>
            <div>
                <label for="matakuliah_id">Matakuliah</label><br>
                <select name="matakuliah_id" id="">
                    <option disabled selected>-----</option>
                    @foreach ($matakuliah as $matkul)
                        <option value="{{ $matkul->id }}">{{ $matkul->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit">Simpan</button>
                <a href="{{ route('laporan.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
