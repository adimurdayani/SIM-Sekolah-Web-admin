<?php

namespace App\Http\Controllers\Api;

use App\Guru;
use App\Http\Controllers\Controller;
use App\Siswa;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $siswa = User::get();
        return response()->json([
            'success' => 1,
            'message' => 'data sukses',
            'siswa' => $siswa
        ]);
    }

    public function login(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:8'
        ]);

        if ($validasi->fails()) {
            $val  = $validasi->errors()->all();
            return $this->error($val[0]);
        }

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return $this->error('Email tidak ditemukan!');
        }

        $validpassword = Hash::check($password, $user->password);

        if (!$validpassword) {
            return $this->error('Password tidak ditemukan');
        }

        return response()->json([
            'success' => 1,
            'message' => 'Login sukses',
            'data' => $user
        ]);
    }

    public function register(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required'
        ]);

        if ($validasi->fails()) {
            $val  = $validasi->errors()->all();
            return $this->error($val[0]);
        }

        if ($request->role == 'Guru') {
            $countGuru = Guru::where('id_card', $request->nomer)->count();
            $guruId = Guru::where('id_card', $request->nomer)->get();
            foreach ($guruId as $val) {
                $guru = Guru::findorfail($val->id);
            }
            if ($countGuru >= 1) {
                $user = User::create([
                    'name' => $guru->nama_guru,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                    'id_card' => $request->nomer,
                ]);
                return response()->json([
                    'success' => 1,
                    'message' => 'Register guru sukses',
                    'data' => $user
                ]);
            } else {
                return $this->error('Maaf User ini tidak terdaftar sebagai guru!');
            }
        } elseif ($request->role == 'Siswa') {
            $countSiswa = Siswa::where('no_induk', $request->nomer)->count();
            $siswaId = Siswa::where('no_induk', $request->nomer)->get();
            foreach ($siswaId as $val) {
                $siswa = Siswa::findorfail($val->id);
            }
            if ($countSiswa >= 1) {
                $user = User::create([
                    'name' => strtolower($siswa->nama_siswa),
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                    'no_induk' => $request->nomer,
                ]);
                return response()->json([
                    'success' => 1,
                    'message' => 'Register siswa sukses',
                    'data' => $user
                ]);
            } else {
                return $this->error('Maaf User ini tidak terdaftar sebagai siswa!');
            }
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
