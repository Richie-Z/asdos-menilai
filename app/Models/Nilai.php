<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = "nilai";
    protected $fillable = ["jawaban", "mahasiswa_id", "laporan_id"];

    protected function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    protected function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}
