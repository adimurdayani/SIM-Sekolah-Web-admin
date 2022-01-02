<?php

namespace App\Http\Controllers\Api;

use App\Guru;
use App\Http\Controllers\Controller;
use App\Jadwal;
use App\Kelas;
use App\Mapel;
use App\Nilai;
use App\Siswa;
use App\Ulangan;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class NilaiController extends Controller
{
    public function index($id)
    {
        $jadwal = Jadwal::with('hari')->with('kelas')->with('mapel')->with('guru')->where('kelas_id', $id)->get();
        return response()->json([
            'success' => 1,
            'message' => 'data sukses',
            'jadwal' => $jadwal
        ]);
    }

    public function ulangan($mapel_id)
    {
        $ulangan = Ulangan::with(['siswa.kelas'])->with('guru')->with('kelas')->with('mapel')->where('mapel_id', $mapel_id)->first();
        return response()->json([
            'success' => 1,
            'message' => 'data sukses',
            'ulangan' => $ulangan
        ]);
    }

    public function error($pesan)
    {
        return response()->json([
            'success' => 0,
            'message' => $pesan
        ]);
    }
}
