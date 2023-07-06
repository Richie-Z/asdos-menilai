@extends('layout.index')
@section('judul', 'Tambah Mahasiswa')
@section('content')
    <h1>Tambah Mahasiswa</h1>
    <div>
        <form action="{{ route('mahasiswa.store') }}" method="POST">
            @csrf
            <div>
                <label for="nim">NIM</label><br>
                <input type="text" name="nim">
            </div>
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
                <button type="submit">Simpan</button>
                <a href="{{ route('mahasiswa.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
