<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = "nilai";
    protected $fillable = ["jawaban", "mahasiswa_id", "laporan_id", "nilai_laporan"];
    protected $appends = ["nilai_jawaban"];

    protected function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    protected function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }

    protected function nilaiJawaban(): Attribute
    {
        return Attribute::make(
            get: fn () => round(collect(json_decode($this->jawaban))->reduce(fn ($carry, $current) => $carry += $current, 0))
        );
    }
}
