<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\NilaiController;
use App\Models\Laporan;
use App\Models\Nilai;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect("", "matakuliah");

Route::resource("matakuliah", MatakuliahController::class)->except("show");
Route::resource("mahasiswa", MahasiswaController::class)->except("show");
Route::resource("laporan", LaporanController::class)->except("show");

Route::prefix("laporan/{laporan}/nilai")->name("nilai.")->group(function () {
    Route::bind("laporan", fn ($value) => Laporan::findOrFail($value));
    Route::bind("nilai", fn ($value) => Nilai::findOrFail($value));

    Route::get("", [NilaiController::class, "index"])->name("index");
    Route::get("create", [NilaiController::class, "create"])->name("create");
    Route::post("", [NilaiController::class, "store"])->name("store");
    Route::get("edit/{nilai}", [NilaiController::class, "edit"])->name("edit");
    Route::put("{nilai}", [NilaiController::class, "update"])->name("update");
    Route::delete("{nilai}", [NilaiController::class, "destroy"])->name("destroy");

});
