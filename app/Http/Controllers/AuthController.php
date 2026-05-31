<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // =========================
    // REGISTER
    // =========================
    public function register(Request $request)
    {
        $request->validate([
            'no_pelanggan' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('no_pelanggan', $request->no_pelanggan)->first();

        // NOMOR TIDAK DITEMUKAN
        if (!$user) {

            return response()->json([
                'status' => false,
                'message' => 'Nomor pelanggan tidak ditemukan'
            ], 404);
        }

        // AKUN SUDAH AKTIF
        if ($user->status_akun == 'aktif') {

            return response()->json([
                'status' => false,
                'message' => 'Akun sudah aktif'
            ], 400);
        }

        // UPDATE DATA REGISTER
        $user->update([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'kecamatan' => $request->kecamatan,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status_akun' => 'aktif'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Registrasi berhasil',
            'data' => $user
        ]);
    }

    // =========================
    // LOGIN
    // =========================
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where(function ($q) use ($request) {
                $q->where('email', $request->email)
                ->orWhere('no_pelanggan', $request->email)
                ->orWhere('no_hp', $request->email);
            })
            ->whereNull('role_id')
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Email, nomor pelanggan, atau password salah'
            ], 401);
        }

        if ($user->status_akun != 'aktif') {
            return response()->json([
                'status' => false,
                'message' => 'Akun belum aktif, silakan registrasi terlebih dahulu'
            ], 403);
        }

        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'data' => $user
        ]);
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)
            ->whereNotNull('role_id')
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password salah');
        }

        session([
            'admin_login' => true,
            'admin_id' => $user->id,
            'admin_nama' => $user->nama,
            'admin_email' => $user->email,
        ]);

        return redirect('/dashboard')->with('success', 'Login berhasil');
    }

    public function logout()
    {
        session()->flush();

        return redirect('/login');
    }
}