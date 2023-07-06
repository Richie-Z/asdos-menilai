@extends('layout.index')
@section('judul', 'Tambah Matakuliah')
@section('content')
    <h1>Tambah Matakuliah</h1>
    <div>
        <form action="{{ route('matakuliah.store') }}" method="POST">
            @csrf
            <div>
                <label for="nama">Nama</label><br>
                <input type="text" name="nama">
            </div>
            <div>
                <label for="kelas">Kelas</label><br>
                <select name="kelas" id="">
                    <option disabled selected>-----</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            <div>
                <label for="max_nilai">Max Nilai</label><br>
                <input type="number" name="max_nilai" max="100">
            </div>
            <div>
                <label for="nilai_laporan">Nilai Laporan</label><br>
                <input type="number" name="nilai_laporan" max="100">
            </div>
            <div>
                <button type="submit">Simpan</button>
                <a href="{{ route('matakuliah.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
