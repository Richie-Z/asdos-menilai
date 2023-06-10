<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = "laporan";
    protected $fillable = ["nama", "jumlah_soal", "matakuliah_id"];

    protected function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class);
    }
}
