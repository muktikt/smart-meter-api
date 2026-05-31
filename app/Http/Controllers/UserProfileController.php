<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show($id)
    {
        $user = User::whereNull('role_id')->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Profil user berhasil diambil',
            'data' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::whereNull('role_id')->findOrFail($id);

        $request->validate([
            'nama' => 'nullable|string',
            'email' => 'nullable|email',
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        $user->update([
            'nama' => $request->nama ?? $user->nama,
            'email' => $request->email ?? $user->email,
            'no_hp' => $request->no_hp ?? $user->no_hp,
            'alamat' => $request->alamat ?? $user->alamat,
            'kecamatan' => $request->kecamatan ?? $user->kecamatan,
            'latitude' => $request->latitude ?? $user->latitude,
            'longitude' => $request->longitude ?? $user->longitude,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => $user
        ]);
    }
}   