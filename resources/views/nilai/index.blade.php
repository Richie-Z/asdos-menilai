@extends('layout.index')
@section('judul', "List Nilai $laporan->nama")
@section('content')
    <h1>List Nilai {{ $laporan->nama }}</h1>
    <div>
        <a href="{{ route('nilai.create', ['laporan' => $laporan->id]) }}">Tambah</a>
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>Nilai</th>
                    <th>Nilai Laporan</th>
                    <th>Nilai Jawaban</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan->nilai as $key => $nilai)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $nilai->mahasiswa->nama }}</td>
                        <td><strong>{{ $nilai->nilai_jawaban + $nilai->nilai_laporan }}</strong></td>
                        <td>{{ $nilai->nilai_laporan }}</td>
                        <td>{{ $nilai->nilai_jawaban }}</td>
                        <td>
                            <a href="{{ route('nilai.edit', ['laporan' => $laporan->id, 'nilai' => $nilai->id]) }}">Edit</a> |
                            <form action="{{ route('nilai.destroy', ['laporan' => $laporan->id, 'nilai' => $nilai->id]) }}" method="POST">
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
