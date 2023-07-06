<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Matakuliah;
use Illuminate\Http\Request;

class LaporanController extends Controller
{

    public function index()
    {
        $laporan = Laporan::orderBy("nama", "asc")->get();
        return view("laporan.index", compact("laporan"));
    }

    public function create()
    {
        return view("laporan.create", ["matakuliah" => Matakuliah::all()]);
    }

    public function store(Request $request)
    {
        try {
            $laporan = new Laporan();
            $laporan->nama = $request->nama;
            $laporan->jumlah_soal = $request->jumlah_soal;
            $laporan->matakuliah_id = $request->matakuliah_id;
            $laporan->save();
            return redirect()->route("laporan.index")->with("status", "Berhasil Tambah");
        } catch (err $err) {
            return redirect()->route("laporan.index")->with("status", "Gagal");
        }
    }

    public function edit(Laporan $laporan)
    {
        return view("laporan.edit", ["laporan" => $laporan, "matakuliah" => Matakuliah::all()]);
    }

    public function update(Request $request, Laporan $laporan)
    {
        try {
            $laporan->nama = $request->nama;
            $laporan->jumlah_soal = $request->jumlah_soal;
            $laporan->matakuliah_id = $request->matakuliah_id;
            $laporan->save();
            return redirect()->route("laporan.index")->with("status", "Berhasil Edit");
        } catch (err $err) {
            return redirect()->route("laporan.index")->with("status", "Gagal");
        }
    }

    public function destroy(Laporan $laporan)
    {
        try {
            $laporan->delete();
            return redirect()->route("laporan.index")->with("status", "Berhasil Hapus");
        } catch (err $err) {
            return redirect()->route("laporan.index")->with("status", "Berhasil Hapus");
        }
    }
}
