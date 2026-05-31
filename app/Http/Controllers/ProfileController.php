<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // =========================
    // HALAMAN PROFILE
    // =========================
    public function index()
    {
        $admin = Auth::user();

        return view('profile.index', compact('admin'));
    }

    // =========================
    // UPDATE PROFILE
    // =========================
    public function update(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'nullable'
        ]);

        $admin->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

        return redirect('/profile')
                ->with('success', 'Profile berhasil diperbarui');
    }

    // =========================
    // UPDATE PASSWORD
    // =========================
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6',
            'konfirmasi_password' => 'required|same:password_baru',
        ]);

        $admin = Auth::user();

        // PASSWORD LAMA SALAH
        if (!Hash::check($request->password_lama, $admin->password)) {

            return back()->with('error', 'Password lama salah');
        }

        // UPDATE PASSWORD
        $admin->update([
            'password' => bcrypt($request->password_baru)
        ]);

        return redirect('/profile')
                ->with('success', 'Password berhasil diperbarui');
    }

    // =========================
    // UPLOAD FOTO PROFILE
    // =========================
    public function uploadFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $admin = Auth::user();

        if ($request->hasFile('foto')) {

            $foto = $request->file('foto');

            $namaFoto = time() . '.' . $foto->getClientOriginalExtension();

            $foto->move(public_path('profile'), $namaFoto);

            $admin->update([
                'foto' => $namaFoto
            ]);
        }

        return redirect('/profile')
                ->with('success', 'Foto profile berhasil diupload');
    }

    // =========================
    // LOGOUT SEMUA DEVICE
    // =========================
    public function logoutAll()
    {
        Auth::logoutOtherDevices(request('password'));

        return redirect('/profile')
                ->with('success', 'Berhasil logout dari semua device');
    }
}