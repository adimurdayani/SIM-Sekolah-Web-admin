<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $mapel = Mapel::with('paket')->get();
        return response()->json([
            'success' => 1,
            'message' => 'data sukses',
            'mapel' => $mapel
        ]);
    }
}
