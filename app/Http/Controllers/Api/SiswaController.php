<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Siswa;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['kelas.paket'])->with(['kelas.guru'])->with(['kelas.guru.mapel'])->with(['kelas.guru.mapel.paket'])->get();
        return response()->json([
            'success' => 1,
            'message' => 'data sukses',
            'siswa' => $siswa
        ]);
    }

    public function siswa_id($no_induk)
    {
        $siswa = Siswa::where('no_induk', $no_induk)->with('kelas')->first();
        return response()->json([
            'success' => 1,
            'message' => 'data sukses',
            'siswa' => $siswa
        ]);
    }

    public function kelas_id($kelas_id)
    {
        $siswa = Siswa::with(['kelas.paket'])->with(['kelas.guru'])->with(['kelas.guru.mapel'])->with(['kelas.guru.mapel.paket'])->where('kelas_id', $kelas_id)->get();
        return response()->json([
            'success' => 1,
            'message' => 'data sukses',
            'siswas' => $siswa
        ]);
    }

    public function siswa_kelas_id($kelas_id)
    {
        $siswa = Siswa::with(['kelas.guru'])->with(['kelas.paket'])->with(['kelas.guru.mapel'])->with(['kelas.guru.mapel.paket'])->where('kelas_id', $kelas_id)->first();
        return response()->json([
            'success' => 1,
            'message' => 'data sukses',
            'data_siswa' => $siswa
        ]);
    }
}
