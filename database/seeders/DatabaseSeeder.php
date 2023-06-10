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
        $matkul = new Matakuliah();
        $matkul->nama = "Basis Data";
        $matkul->nilai_laporan = 15;
        $matkul->save();
    }
}
