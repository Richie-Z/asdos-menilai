@extends('layout.index')
@section('judul', 'Mahasiswa')
@section('content')
    <h1>Mahasiswa</h1>
    <div>
        <a href="{{ route('mahasiswa.create') }}">Tambah</a>
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mahasiswa as $key => $mhs)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $mhs->nim }}</td>
                        <td>{{ $mhs->nama }}</td>
                        <td>{{ $mhs->kelas }}</td>
                        <td>
                            <a href="{{ route('mahasiswa.edit', ['mahasiswa' => $mhs->id]) }}">Edit</a> |
                            <form action="{{ route('mahasiswa.destroy', ['mahasiswa' => $mhs->id]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button>Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
