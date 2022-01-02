<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['guru.mapel'])->with(['guru.mapel.paket'])->with('paket')->get();
        return response()->json([
            'success' => 1,
            'message' => 'data sukses',
            'kelas' => $kelas
        ]);
    }
}
