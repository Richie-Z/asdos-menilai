@extends('layout.index')
@section('judul', "Tambah Nilai $laporan->nama")
@section('content')
    @php
        function checked($condition, $n = 0)
        {
            global $laporan;
            if ($condition == 'salah') {
                return $n !== 0 ?: 'checked';
            }
            if ($condition == 'benar') {
                return $n !== $laporan->bobot ?: 'checked';
            }
        
            return 'checked';
        }
    @endphp
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <h1>Tambah Nilai {{ $laporan->nama }}</h1>
    <div>
        <form action="{{ route('nilai.update', ['laporan' => $laporan->id, 'nilai' => $nilai->id]) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="dropdown">
                <label for="mahasiswa_id">Mahasiswa</label><br>
                <input type="text" name="mahasiswa" id="input-text" placeholder="Select an option" value="{{ $nilai->mahasiswa->nama }}" readonly>
                <input type="hidden" name="mahasiswa_id" value="{{ $nilai->mahasiswa_id }}">
            </div>
            <div>
                <label for="nilai_laporan">Nilai Laporan</label><br>
                <input type="number" name="nilai_laporan" value="{{ $nilai->nilai_laporan }}">
            </div>
            @foreach ($jawaban as $i => $n)
                @php
                    $i += 1;
                @endphp
                <br />
                <div>
                    <label for="nomor{{ $i }}">Nomor {{ $i }}</label><br>
                    <input type="radio" name="nomor{{ $i }}" onchange="handleRadioChange({{ $i }})" value="0">Salah
                    {{-- {{ checked('salah', $n) }}>Salah --}}
                    <input type="radio" name="nomor{{ $i }}" onchange="handleRadioChange({{ $i }})" value="1">Benar
                    {{-- {{ checked('benar', $n) }}>Benar --}}
                    <input type="radio" name="nomor{{ $i }}" onchange="handleRadioChange({{ $i }})" value="2">Optional
                    {{-- {{ checked('optional') }}>Optional --}}
                    <input type="text" name="jawaban[]" id="inputNomor{{ $i }}" style="display:block" value="{{ $n }}">
                </div>
            @endforeach
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
