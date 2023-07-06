@extends('layout.index')
@section('judul', 'Edit Mahasiswa')
@section('content')
    <h1>Edit Mahasiswa</h1>
    <div>
        <form action="{{ route('mahasiswa.update', ['mahasiswa' => $mhs->id]) }}" method="POST">
            @csrf
            <div>
                <label for="nim">NIM</label><br>
                <input type="text" name="nim" value="{{ $mhs->nim }}">
            </div>
            <div>
                <label for="nama">Nama</label><br>
                <input type="text" name="nama" value="{{ $mhs->nama }}">
            </div>
            <div>
                <label for="kelas">Kelas</label><br>
                <select name="kelas" id="">
                    <option value="1" {{ $mhs->kelas != 1 ?: 'selected' }}>1</option>
                    <option value="2" {{ $mhs->kelas != 2 ?: 'selected' }}>2</option>
                </select>
            </div>
            <div>
                <button type="submit">Simpan</button>
                <a href="{{ route('mahasiswa.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
