<?php

namespace App\Http\Controllers\Api;

use App\Guru;
use App\Http\Controllers\Controller;
use App\Mapel;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index($id)
    {
        $guru = Guru::where('mapel_id', $id)->with('mapel')->get();
        return response()->json([
            'success' => 1,
            'message' => 'data sukses',
            'gurus' => $guru
        ]);
    }

    public function guru_id($id_card)
    {
        $guru = Guru::where('id_card', $id_card)->with('mapel')->first();
        return response()->json([
            'success' => 1,
            'message' => 'data sukses',
            'guru' => $guru
        ]);
    }
}
