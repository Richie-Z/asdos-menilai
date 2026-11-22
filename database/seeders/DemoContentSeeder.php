<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $timestamp = date('Y-m-d H:i:s');

        $courses = [
            ['nama' => 'Praktikum Basis Data', 'kelas' => '1', 'nilai_laporan' => 20, 'max_nilai' => 100],
            ['nama' => 'Praktikum Pemrograman Web', 'kelas' => '2', 'nilai_laporan' => 30, 'max_nilai' => 100],
            ['nama' => 'Praktikum Struktur Data', 'kelas' => '1', 'nilai_laporan' => 25, 'max_nilai' => 100],
            ['nama' => 'Praktikum Sistem Operasi', 'kelas' => '2', 'nilai_laporan' => 40, 'max_nilai' => 100],
            ['nama' => 'Praktikum Jaringan Komputer', 'kelas' => '1', 'nilai_laporan' => 10, 'max_nilai' => 100],
            ['nama' => 'Praktikum Rekayasa Perangkat Lunak', 'kelas' => '2', 'nilai_laporan' => 35, 'max_nilai' => 100],
        ];

        $courseIds = [];
        $coursesByNama = [];

        foreach ($courses as $course) {
            $where = ['nama' => $course['nama'], 'kelas' => $course['kelas']];

            if (DB::table('matakuliah')->where($where)->count() === 0) {
                DB::table('matakuliah')->insert([
                    'nama' => $course['nama'],
                    'kelas' => $course['kelas'],
                    'nilai_laporan' => $course['nilai_laporan'],
                    'max_nilai' => $course['max_nilai'],
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }

            $courseIds[$course['nama']] = DB::table('matakuliah')->where($where)->value('id');
            $coursesByNama[$course['nama']] = $course;
        }

        $students = [
            ['nim' => '20231001', 'nama' => 'Rizky Pratama Nugroho', 'kelas' => '1'],
            ['nim' => '20231002', 'nama' => 'Nadia Putri Maharani', 'kelas' => '1'],
            ['nim' => '20231003', 'nama' => 'Bima Saputra Wijaya', 'kelas' => '1'],
            ['nim' => '20231004', 'nama' => 'Salsa Amelia Rahmawati', 'kelas' => '1'],
            ['nim' => '20231005', 'nama' => 'Dimas Arya Kusuma', 'kelas' => '1'],
            ['nim' => '20231006', 'nama' => 'Alya Zahra Ramadhani', 'kelas' => '1'],
            ['nim' => '20232001', 'nama' => 'Fajar Hidayatulloh', 'kelas' => '2'],
            ['nim' => '20232002', 'nama' => 'Intan Permata Sari', 'kelas' => '2'],
            ['nim' => '20232003', 'nama' => 'Gita Anindya Kusuma', 'kelas' => '2'],
            ['nim' => '20232004', 'nama' => 'Reza Mahendra Putra', 'kelas' => '2'],
            ['nim' => '20232005', 'nama' => 'Citra Dewi Anggraini', 'kelas' => '2'],
            ['nim' => '20232006', 'nama' => 'Yudha Prasetyo Nugroho', 'kelas' => '2'],
        ];

        $studentIds = ['1' => [], '2' => []];

        foreach ($students as $student) {
            if (DB::table('mahasiswa')->where('nim', $student['nim'])->count() === 0) {
                DB::table('mahasiswa')->insert([
                    'nim' => $student['nim'],
                    'nama' => $student['nama'],
                    'kelas' => $student['kelas'],
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }

            $studentIds[$student['kelas']][] = DB::table('mahasiswa')->where('nim', $student['nim'])->value('id');
        }

        $reports = [
            ['nama' => 'Laporan 1: Perancangan Skema dan ERD', 'course' => 'Praktikum Basis Data', 'jumlah_soal' => 4],
            ['nama' => 'Laporan 2: Query SQL dan Normalisasi', 'course' => 'Praktikum Basis Data', 'jumlah_soal' => 4],
            ['nama' => 'Laporan 1: HTML, CSS, dan Layout Responsif', 'course' => 'Praktikum Pemrograman Web', 'jumlah_soal' => 5],
            ['nama' => 'Laporan 2: Form Validation dan Session', 'course' => 'Praktikum Pemrograman Web', 'jumlah_soal' => 5],
            ['nama' => 'Laporan 1: Implementasi Stack dan Queue', 'course' => 'Praktikum Struktur Data', 'jumlah_soal' => 5],
            ['nama' => 'Laporan 2: Traversal Pohon Biner', 'course' => 'Praktikum Struktur Data', 'jumlah_soal' => 5],
            ['nama' => 'Laporan 1: Penjadwalan Proses', 'course' => 'Praktikum Sistem Operasi', 'jumlah_soal' => 6],
            ['nama' => 'Laporan 1: Konfigurasi VLAN dan Routing', 'course' => 'Praktikum Jaringan Komputer', 'jumlah_soal' => 6],
            ['nama' => 'Laporan 1: Use Case dan Diagram UML', 'course' => 'Praktikum Rekayasa Perangkat Lunak', 'jumlah_soal' => 5],
        ];

        $reportRows = [];

        foreach ($reports as $report) {
            $where = ['nama' => $report['nama'], 'matakuliah_id' => $courseIds[$report['course']]];

            if (DB::table('laporan')->where($where)->count() === 0) {
                DB::table('laporan')->insert([
                    'nama' => $report['nama'],
                    'jumlah_soal' => $report['jumlah_soal'],
                    'matakuliah_id' => $courseIds[$report['course']],
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }

            $reportRows[] = [
                'id' => DB::table('laporan')->where($where)->value('id'),
                'course' => $report['course'],
                'jumlah_soal' => $report['jumlah_soal'],
            ];
        }

        $totals = [94, 87, 80, 74, 68, 61];

        foreach ($reportRows as $reportIndex => $reportRow) {
            $course = $coursesByNama[$reportRow['course']];
            $pool = $course['max_nilai'] - $course['nilai_laporan'];
            $bobot = intdiv($pool, $reportRow['jumlah_soal']);
            $offset = ($reportIndex % 3) - 1;
            $classStudents = $studentIds[$course['kelas']];

            foreach ($classStudents as $studentIndex => $studentId) {
                if (DB::table('nilai')->where('mahasiswa_id', $studentId)->where('laporan_id', $reportRow['id'])->count() > 0) {
                    continue;
                }

                $total = max(55, min(98, $totals[$studentIndex % count($totals)] + $offset));
                $answerSum = max(0, min($pool, $total - $course['nilai_laporan']));
                $jawaban = array_fill(0, $reportRow['jumlah_soal'], 0);

                for ($i = 0; $i < $reportRow['jumlah_soal'] && $answerSum > 0; $i++) {
                    $value = min($bobot, $answerSum);
                    $jawaban[$i] = $value;
                    $answerSum -= $value;
                }

                DB::table('nilai')->insert([
                    'jawaban' => json_encode($jawaban),
                    'nilai_laporan' => $course['nilai_laporan'],
                    'mahasiswa_id' => $studentId,
                    'laporan_id' => $reportRow['id'],
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }
        }
    }
}
