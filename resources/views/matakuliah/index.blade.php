@extends('layout.index')
@section('judul', 'Matakuliah')
@section('content')
    <h1>Matakuliah</h1>
    <div>
        <a href="{{ route('matakuliah.create') }}">Tambah</a>
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Nilai Laporan</th>
                    <th>Nilai Jawaban</th>
                    <th>Max Nilai</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($matakuliah as $key => $matkul)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $matkul->nama }}</td>
                        <td>{{ $matkul->kelas }}</td>
                        <td>{{ $matkul->nilai_laporan }}</td>
                        <td>{{ $matkul->nilai_jawaban }}</td>
                        <td>{{ $matkul->max_nilai }}</td>
                        <td>
                            <a href="{{ route('matakuliah.edit', ['matakuliah' => $matkul->id]) }}">Edit</a> |
                            <form action="{{ route('matakuliah.destroy', ['matakuliah' => $matkul->id]) }}" method="POST">
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
