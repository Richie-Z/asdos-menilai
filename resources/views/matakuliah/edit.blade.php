@extends('layout.index')
@section('judul', 'Edit Matakuliah')
@section('content')
    <h1>Edit Matakuliah</h1>
    <div>
        <form action="{{ route('matakuliah.update', ['matakuliah' => $matkul->id]) }}" method="POST">
            @csrf
            <div>
                <label for="nama">Nama</label><br>
                <input type="text" name="nama" value="{{ $matkul->nama }}">
            </div>
            <div>
                <label for="kelas">Kelas</label><br>
                <select name="kelas" id="">
                    <option value="1" {{ $matkul->kelas != 1 ?: 'selected' }}>1</option>
                    <option value="2" {{ $matkul->kelas != 2 ?: 'selected' }}>2</option>
                </select>
            </div>
            <div>
                <label for="max_nilai">Max Nilai</label><br>
                <input type="number" name="max_nilai" max="100" value="{{ $matkul->max_nilai }}">
            </div>
            <div>
                <label for="nilai_laporan">Nilai Laporan</label><br>
                <input type="number" name="nilai_laporan" max="100" value="{{ $matkul->nilai_laporan }}">
            </div>
            <div>
                <button type="submit">Simpan</button>
                <a href="{{ route('matakuliah.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
