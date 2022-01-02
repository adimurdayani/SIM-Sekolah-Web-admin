<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Jadwal;

class JadwalController extends Controller
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

    public function nilai_jadwal($id)
    {
        $jadwal = Jadwal::with('hari')->with('kelas')->with('mapel')->with('guru')->where('kelas_id', $id)->get();
        return response()->json([
            'success' => 1,
            'message' => 'data sukses',
            'nilai_jadwal' => $jadwal
        ]);
    }
}
