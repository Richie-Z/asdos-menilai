<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    public function index()
    {
        $matakuliah = Matakuliah::all();
        return view("matakuliah.index", compact("matakuliah"));
    }

    public function create()
    {
        return view("matakuliah.create");
    }

    public function store(Request $request)
    {
        try {
            $matakuliah = new Matakuliah();
            $matakuliah->nama = $request->nama;
            $matakuliah->kelas = $request->kelas;
            $matakuliah->nilai_laporan = $request->nilai_laporan;
            $matakuliah->max_nilai = $request->max_nilai;
            $matakuliah->save();
            return redirect()->route("matakuliah.index")->with("status", "Berhasil Tambah");
        } catch (err $err) {
            return redirect()->route("matakuliah.index")->with("status", "Gagal");
        }
    }

    public function show(matakuliah $matakuliah)
    {
    }

    public function edit(matakuliah $matakuliah)
    {
        return view("matakuliah.edit", ["matkul" => $matakuliah]);
    }

    public function update(Request $request, matakuliah $matakuliah)
    {
        try {
            $matakuliah->nama = $request->nama;
            $matakuliah->kelas = $request->kelas;
            $matakuliah->nilai_laporan = $request->nilai_laporan;
            $matakuliah->max_nilai = $request->max_nilai;
            $matakuliah->save();
            return redirect()->route("matakuliah.index")->with("status", "Berhasil Edit");
        } catch (err $err) {
            return redirect()->route("matakuliah.index")->with("status", "Gagal");
        }
    }

    public function destroy(matakuliah $matakuliah)
    {
        try {
            $matakuliah->delete();
            return redirect()->route("matakuliah.index")->with("status", "Berhasil Hapus");
        } catch (err $err) {
            return redirect()->route("matakuliah.index")->with("status", "Berhasil Hapus");
        }
    }
}
