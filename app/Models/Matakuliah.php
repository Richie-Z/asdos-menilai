<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    protected $table = "matakuliah";
    protected $fillable = ["nama", "nilai_laporan", "max_nilai", "kelas"];
    protected $appends = ["nilai_jawaban"];

    protected function nilaiJawaban(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->max_nilai - $this->nilai_laporan
        );
    }
}
