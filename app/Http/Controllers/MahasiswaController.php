<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return view("mahasiswa.index", compact("mahasiswa"));
    }

    public function create()
    {
        return view("mahasiswa.create");
    }

    public function store(Request $request)
    {
        try {
            $mahasiswa = new Mahasiswa();
            $mahasiswa->nama = $request->nama;
            $mahasiswa->kelas = $request->kelas;
            $mahasiswa->nim = $request->nim;
            $mahasiswa->save();
            return redirect()->route("mahasiswa.index")->with("status", "Berhasil Tambah");
        } catch (err $err) {
            return redirect()->route("mahasiswa.index")->with("status", "Gagal");
        }
    }

    public function show(Mahasiswa $mahasiswa)
    {
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view("mahasiswa.edit", ["mhs" => $mahasiswa]);
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        try {
            $mahasiswa->nama = $request->nama;
            $mahasiswa->kelas = $request->kelas;
            $mahasiswa->nim = $request->nim;
            $mahasiswa->save();
            return redirect()->route("mahasiswa.index")->with("status", "Berhasil Edit");
        } catch (err $err) {
            return redirect()->route("mahasiswa.index")->with("status", "Gagal");
        }
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        try {
            $mahasiswa->delete();
            return redirect()->route("mahasiswa.index")->with("status", "Berhasil Hapus");
        } catch (err $err) {
            return redirect()->route("mahasiswa.index")->with("status", "Berhasil Hapus");
        }
    }
}
