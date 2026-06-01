<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // =========================
    // HALAMAN PROFILE
    // =========================
    public function index()
    {
        $admin = User::find(session('admin_id'));

        return view('profile.index', compact('admin'));
    }

    // =========================
    // UPDATE PROFILE
    // =========================
    public function update(Request $request)
    {
        $admin = User::find(session('admin_id'));

        $request->validate([
            'nama'  => 'required',
            'email' => 'required|email',
            'no_hp' => 'nullable'
        ]);

        $admin->update([
            'nama'  => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

        // Update session supaya nama di navbar ikut berubah
        session(['admin_nama' => $request->nama]);
        session(['admin_email' => $request->email]);

        return redirect('/admin-profile')
                ->with('success', 'Profile berhasil diperbarui');
    }

    // =========================
    // UPDATE PASSWORD
    // =========================
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama'      => 'required',
            'password_baru'      => 'required|min:6',
            'konfirmasi_password' => 'required|same:password_baru',
        ]);

        $admin = User::find(session('admin_id'));

        if (!$admin) {
            return redirect('/login')->with('error', 'Session habis, silakan login ulang');
        }

        // PASSWORD LAMA SALAH
        if (!Hash::check($request->password_lama, $admin->password)) {
            return back()->with('error', 'Password lama salah');
        }

        // UPDATE PASSWORD
        $admin->update([
            'password' => bcrypt($request->password_baru)
        ]);

        return redirect('/admin-profile')
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

        $admin = User::find(session('admin_id'));

        if (!$admin) {
            return redirect('/login')->with('error', 'Session habis, silakan login ulang');
        }

        if ($request->hasFile('foto')) {
            $foto     = $request->file('foto');
            $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('profile'), $namaFoto);

            $admin->update([
                'foto' => $namaFoto
            ]);
        }

        return redirect('/admin-profile')
                ->with('success', 'Foto profile berhasil diupload');
    }

    // =========================
    // LOGOUT SEMUA DEVICE
    // =========================
    public function logoutAll()
    {
        // Karena pakai session manual, cukup flush session saja
        session()->flush();

        return redirect('/login')
                ->with('success', 'Berhasil logout dari semua device');
    }
}