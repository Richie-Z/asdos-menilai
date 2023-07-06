<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matakuliah', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->enum("kelas", [1, 2]);
            $table->integer("nilai_laporan")->nullable()->default(0);
            $table->integer("max_nilai")->nullable()->default(100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matakuliah');
    }
};
