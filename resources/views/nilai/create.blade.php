@extends('layout.index')
@section('judul', "Tambah Nilai $laporan->nama")
@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown input[type="text"] {
            cursor: pointer;
        }

        .dropdown ul.dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            display: none;
            list-style-type: none;
            padding: 0;
            margin: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            z-index: 1;
        }

        .dropdown ul.dropdown-menu li {
            padding: 8px;
            cursor: pointer;
        }

        .dropdown ul.dropdown-menu li:hover {
            background-color: #f0f0f0;
        }
    </style>
    <h1>Tambah Nilai {{ $laporan->nama }}</h1>
    <div>
        <form action="{{ route('nilai.store', ['laporan' => $laporan->id]) }}" method="POST">
            @csrf
            <div class="dropdown">
                <label for="mahasiswa_id">Mahasiswa</label><br>
                <input type="text" name="mahasiswa" id="input-text" placeholder="Select an option">
                <ul class="dropdown-menu">
                    @foreach ($mahasiswa as $mhs)
                        <li data-value="{{ $mhs->id }}">{{ $mhs->nama }}</li>
                    @endforeach
                </ul>
                <input type="hidden" name="mahasiswa_id">
            </div>
            <div>
                <label for="nilai_laporan">Nilai Laporan</label><br>
                <input type="number" name="nilai_laporan">
            </div>
            @for ($i = 1; $i <= $laporan->jumlah_soal; $i++)
                <br />
                <div>
                    <label for="nomor{{ $i }}">Nomor {{ $i }}</label><br>
                    <input type="radio" name="nomor{{ $i }}" onchange="handleRadioChange({{ $i }})" value="0">Salah
                    <input type="radio" name="nomor{{ $i }}" onchange="handleRadioChange({{ $i }})" value="1" checked>Benar
                    <input type="radio" name="nomor{{ $i }}" onchange="handleRadioChange({{ $i }})" value="2">Optional
                    <input type="text" name="jawaban[]" id="inputNomor{{ $i }}" style="display:none" value="{{ $laporan->bobot }}">
                </div>
            @endfor
            <div>
                <button type="submit">Simpan</button>
                <a href="{{ route('laporan.index') }}">Cancel</a>
            </div>
        </form>
    </div>
    <script>
        function handleRadioChange(id) {
            var selectedValue = $(`input[type="radio"][name="nomor${id}"]:checked`).val();
            const input = $(`input#inputNomor${id}`);
            switch (selectedValue) {
                case "0":
                    input.hide()
                    input.val(0)
                    break;
                case "1":
                    input.hide()
                    input.val({{ $laporan->bobot }})
                    break;
                case "2":
                    input.show()
                    input.val(0)
                    break;
                default:
                    break;
            }

        }
        $(document).ready(function() {
            $('.dropdown input[type="text"]').click(function() {
                $(this).siblings('ul.dropdown-menu').toggle();
            });

            $('.dropdown input[type="text"]').on('input', function() {
                var searchText = $(this).val().toLowerCase();
                $(this).siblings('ul.dropdown-menu').children('li').each(function() {
                    var optionText = $(this).text().toLowerCase();
                    if (optionText.indexOf(searchText) > -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
            $('.dropdown ul.dropdown-menu li').click(function() {
                var value = $(this).data('value');
                var text = $(this).text();
                $(this).closest('.dropdown').find('input[type="text"]').val(text);
                $(this).closest('.dropdown').find('input[type="hidden"]').val(value);
                $(this).closest('.dropdown-menu').hide();
            });
        });
    </script>

@endsection
