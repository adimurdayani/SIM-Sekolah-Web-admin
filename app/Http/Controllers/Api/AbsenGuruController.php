<?php

namespace App\Http\Controllers\Api;

use App\Absen;
use App\Guru;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AbsenGuruController extends Controller
{
    public function index()
    {
        $absen = Absen::with(['guru.mapel'])->with(['guru.mapel.paket'])->with('kehadiran')->get();
        return response()->json([
            'success' => 1,
            'message' => 'data sukses',
            'absen' => $absen
        ]);
    }

    public function absen(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'id_card' => 'required',
            'kehadiran_id' => 'required'
        ]);

        if ($validasi->fails()) {
            $val  = $validasi->errors()->all();
            return $this->error($val[0]);
        }

        $cekGuru = Guru::where('id_card', $request->id_card)->count();
        if ($cekGuru >= 1) {
            $guru = Guru::where('id_card', $request->id_card)->first();
            $user = User::where('id', $id)->first();
            if ($guru->id_card == $user->id_card) {
                $cekAbsen = Absen::where('guru_id', $guru->id)->where('tanggal', date('Y-m-d'))->count();
                if ($cekAbsen == 0) {
                    if (date('w') != '0' && date('w') != '6') {
                        if (date('H:i:s') >= '06:00:00') {
                            if (date('H:i:s') >= '09:00:00') {
                                if (date('H:i:s') >= '16:15:00') {
                                    $absen = Absen::create([
                                        'tanggal' => date('Y-m-d'),
                                        'guru_id' => $guru->id,
                                        'kehadiran_id' => '6',
                                    ]);
                                    return response()->json([
                                        'success' => 1,
                                        'message' => 'Maaf sekarang sudah waktunya pulang!',
                                        'absen' => $absen
                                    ]);
                                } else {
                                    if ($request->kehadiran_id == '1') {
                                        $terlambat = date('H') - 9 . ' Jam ' . date('i') . ' Menit';
                                        if (date('H') - 9 == 0) {
                                            $terlambat = date('i') . ' Menit';
                                        }
                                        $absen = Absen::create([
                                            'tanggal' => date('Y-m-d'),
                                            'guru_id' => $guru->id,
                                            'kehadiran_id' => '5',
                                        ]);
                                        return response()->json([
                                            'success' => 1,
                                            'message' => 'Maaf anda terlambat ' . $terlambat . '!',
                                            'absen' => $absen
                                        ]);
                                    } else {
                                        $absen = Absen::create([
                                            'tanggal' => date('Y-m-d'),
                                            'guru_id' => $guru->id,
                                            'kehadiran_id' => $request->kehadiran_id,
                                        ]);
                                        return response()->json([
                                            'success' => 1,
                                            'message' => 'Anda hari ini berhasil absen!',
                                            'absen' => $absen
                                        ]);
                                    }
                                }
                            } else {
                                $absen = Absen::create([
                                    'tanggal' => date('Y-m-d'),
                                    'guru_id' => $guru->id,
                                    'kehadiran_id' => $request->kehadiran_id,
                                ]);
                                return response()->json([
                                    'success' => 1,
                                    'message' => 'Anda hari ini berhasil absen tepat waktu!',
                                    'absen' => $absen
                                ]);
                            }
                        } else {
                            return $this->error('Maaf absensi di mulai jam 6 pagi!');
                        }
                    } else {
                        $namaHari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
                        $d = date('w');
                        $hari = $namaHari[$d];
                        return $this->error('Maaf sekolah hari ' . $hari . ' libur!');
                    }
                } else {
                    return $this->error('Maaf absensi tidak bisa dilakukan 2x!');
                }
            } else {
                return $this->error('Maaf id card ini bukan milik anda!');
            }
        } else {
            return $this->error('Maaf id card ini tidak terdaftar!');
        }
    }

    public function error($pesan)
    {
        return response()->json([
            'success' => 0,
            'message' => $pesan
        ]);
    }
}
