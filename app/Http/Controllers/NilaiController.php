<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Mahasiswa;
use App\Models\Nilai;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Laporan $laporan)
    {
        return view("nilai.index", ["laporan" => $laporan]);
    }

    public function create(Laporan $laporan)
    {
        $kelas = $laporan->matakuliah->kelas;
        $mahasiswa = Mahasiswa::where("kelas", $kelas)->get();

        return view("nilai.create", ["laporan" => $laporan, "mahasiswa" => $mahasiswa]);
    }


    public function store(Request $request, Laporan $laporan)
    {
        try {
            $mahasiswaID = $request->mahasiswa_id;
            if (empty($mahasiswaID)) {
                $mahasiswa = explode("-", $request->mahasiswa);
                $mahasiswaID = $mahasiswa[0];
                if (Mahasiswa::where("nim", $mahasiswa[0])->count() == 0)
                    $mahasiswaID = Mahasiswa::create([
                        "nim" => $mahasiswa[0],
                        "nama" => $mahasiswa[1],
                        "kelas" => $laporan->matakuliah->kelas
                    ])->id;
            }
            $nilai = new Nilai();
            $nilai->laporan_id = $laporan->id;
            $nilai->mahasiswa_id = $mahasiswaID;
            $nilai->jawaban = json_encode($request->jawaban);
            $nilai->nilai_laporan = $request->nilai_laporan;
            $nilai->save();
            return redirect()->route("nilai.index", ["laporan" => $laporan->id])->with("status", "Berhasil Tambah");
        } catch (err $err) {
            return redirect()->route("nilai.index", ["laporan" => $laporan->id])->with("status", "Gagal");
        }
    }

    public function edit(Laporan $laporan, Nilai $nilai)
    {
        return view("nilai.edit", ["laporan" => $laporan, "nilai" => $nilai, "jawaban" => json_decode($nilai->jawaban)]);
    }

    public function update(Request $request, Laporan $laporan, Nilai $nilai)
    {
        try {
            $mahasiswaID = $request->mahasiswa_id;
            $nilai->laporan_id = $laporan->id;
            $nilai->mahasiswa_id = $mahasiswaID;
            $nilai->jawaban = json_encode($request->jawaban);
            $nilai->nilai_laporan = $request->nilai_laporan;
            $nilai->save();
            return redirect()->route("nilai.index", ["laporan" => $laporan->id])->with("status", "Berhasil Update");
        } catch (err $err) {
            return redirect()->route("nilai.index", ["laporan" => $laporan->id])->with("status", "Gagal");
        }
    }

    public function destroy(Laporan $laporan, Nilai $nilai)
    {
        try {
            $nilai->delete();
            return redirect()->route("nilai.index", ["laporan" => $laporan->id])->with("status", "Berhasil Hapus");
        } catch (err $err) {
            return redirect()->route("nilai.index", ["laporan" => $laporan->id])->with("status", "Berhasil Hapus");
        }
    }
}
