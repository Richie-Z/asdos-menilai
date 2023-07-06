<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('judul', 'Penilaian')</title>
</head>

<body>
    <header>
        <ul>
            <li><a href="{{ route('matakuliah.index') }}">Matakuliah</a></li>
            <li><a href="{{ route('mahasiswa.index') }}">Mahasiswa</a></li>
            <li><a href="{{ route('laporan.index') }}">Laporan</a></li>
        </ul>
        @if (session()->has('status'))
            <h5>{{ session()->get('status') }}</h5>
        @endif
    </header>
    @yield('content')
    <footer>
        <i>
            <pre>gini doang.</pre>
        </i>
    </footer>
</body>

</html>
