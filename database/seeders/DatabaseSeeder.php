<?php

namespace Database\Seeders;

use App\Models\Matakuliah;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->matkul();
    }

    private function matkul(): void
    {
        for ($i = 0; $i < 2; $i++) {
            $matkul = new Matakuliah();
            $matkul->nama = "Basis Data K" . $i + 1;
            $matkul->kelas = $i + 1;
            $matkul->nilai_laporan = 15;
            $matkul->save();
        }
    }
}
