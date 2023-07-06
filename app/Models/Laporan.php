<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Laporan extends Model
{
    protected $table = "laporan";
    protected $fillable = ["nama", "jumlah_soal", "matakuliah_id"];
    protected $appends = ["bobot"];

    protected function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class);
    }

    protected function nilai()
    {
        return $this->hasMany(Nilai::class)
            ->orderBy(
                DB::raw('(SELECT nim FROM mahasiswa WHERE mahasiswa.id = nilai.mahasiswa_id)')
            );
    }

    protected function bobot(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->matakuliah->nilai_jawaban / $this->jumlah_soal
        );
    }
}
