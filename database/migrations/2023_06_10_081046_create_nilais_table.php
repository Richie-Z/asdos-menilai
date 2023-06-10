<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->json("jawaban");
            $table->unsignedBigInteger("mahasiswa_id");
            $table->unsignedBigInteger("laporan_id");
            $table->timestamps();

            $table->foreign("mahasiswa_id")->references("id")->on("mahasiswa")->onDelete("cascade");
            $table->foreign("laporan_id")->references("id")->on("laporan")->onDelete("cascade");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
