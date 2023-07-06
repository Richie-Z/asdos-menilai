@extends('layout.index')
@section('judul', 'Laporan')
@section('content')
    <h1>Laporan</h1>
    <div>
        <a href="{{ route('laporan.create') }}">Tambah</a>
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Laporan</th>
                    <th>Matakuliah</th>
                    <th>Kelas</th>
                    <th>Jumlah Soal</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan as $key => $lapor)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $lapor->nama }}</td>
                        <td>{{ $lapor->matakuliah->nama }}</td>
                        <td>{{ $lapor->matakuliah->kelas }}</td>
                        <td>{{ $lapor->jumlah_soal }}</td>
                        <td>
                            <a href="{{ route('laporan.edit', ['laporan' => $lapor->id]) }}">Edit</a> |
                            <a href="{{ route('nilai.index', ['laporan' => $lapor->id]) }}">Nilai</a> |
                            <form action="{{ route('laporan.destroy', ['laporan' => $lapor->id]) }}" method="POST">
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
