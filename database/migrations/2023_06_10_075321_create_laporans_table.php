<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->integer("jumlah_soal");
            $table->unsignedBigInteger("matakuliah_id");
            $table->timestamps();

            $table->foreign("matakuliah_id")->references("id")->on("matakuliah")->onDelete("cascade");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
