<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Models\Tagihan;
use App\Models\MeterReading;
use App\Models\Pengaduan;

class PelangganController extends Controller
{
    // =========================
    // LIST PELANGGAN
    // =========================
    public function index(Request $request)
    {
        $pelangganQuery = User::where(function ($query) {
            $query->whereHas('role', function ($q) {
                $q->where('slug', 'pelanggan');
            })->orWhereNull('role_id');
        });

        if ($request->filled('search')) {
            $search = $request->search;

            $pelangganQuery->where(function ($query) use ($search) {
                $query->where('nama', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('no_pelanggan', 'like', "%$search%")
                    ->orWhere('no_hp', 'like', "%$search%");
            });
        }

        if ($request->filled('kecamatan')) {
            $pelangganQuery->where('kecamatan', $request->kecamatan);
        }

        if ($request->filled('status_akun')) {
            if ($request->status_akun == 'aktif') {
                $pelangganQuery->where('status_akun', 'aktif');
            }

            if ($request->status_akun == 'belum_registrasi') {
                $pelangganQuery->where(function ($query) {
                    $query->whereNull('status_akun')
                        ->orWhere('status_akun', '')
                        ->orWhere('status_akun', '!=', 'aktif');
                });
            }
        }

        if ($request->filled('device')) {
            if ($request->device == 'terhubung') {
                $pelangganQuery->whereNotNull('device_id')
                    ->where('device_id', '!=', '');
            }

            if ($request->device == 'belum_login') {
                $pelangganQuery->where(function ($query) {
                    $query->whereNull('device_id')
                        ->orWhere('device_id', '');
                });
            }
        }

        $pelanggan = $pelangganQuery->latest()->get();

        $totalPelanggan = User::where(function ($query) {
            $query->whereHas('role', function ($q) {
                $q->where('slug', 'pelanggan');
            })->orWhereNull('role_id');
        })->count();

        $pelangganAktif = User::where('status_akun', 'aktif')->count();

        $pelangganNonaktif = User::where(function ($query) {
            $query->whereNull('status_akun')
                ->orWhere('status_akun', '')
                ->orWhere('status_akun', '!=', 'aktif');
        })->count();

        $deviceTerhubung = User::whereNotNull('device_id')
            ->where('device_id', '!=', '')
            ->count();

        return view('pelanggan.index', compact(
            'pelanggan',
            'totalPelanggan',
            'pelangganAktif',
            'pelangganNonaktif',
            'deviceTerhubung'
        ));
    }

    // =========================
    // DETAIL PELANGGAN
    // =========================
    public function detail($id)
    {
        $pelanggan = User::where(function ($query) {
            $query->whereHas('role', function ($query) {
                $query->where('slug', 'pelanggan');
            })->orWhereNull('role_id');
        })->findOrFail($id);

        $tagihan = Tagihan::where('user_id', $id)
                        ->latest()
                        ->get();

        $meter = MeterReading::where('user_id', $id)
                            ->latest()
                            ->get();

        $pengaduan = Pengaduan::where('user_id', $id)
                            ->latest()
                            ->get();

        return view('pelanggan.detail', compact(
            'pelanggan',
            'tagihan',
            'meter',
            'pengaduan'
        ));
    }

    // =========================
    // FORM EDIT
    // =========================
    public function edit($id)
    {
        $pelanggan = User::where(function ($query) {
            $query->whereHas('role', function ($query) {
                $query->where('slug', 'pelanggan');
            })->orWhereNull('role_id');
        })->findOrFail($id);

        return view('pelanggan.edit', compact('pelanggan'));
    }

    // =========================
    // FORM CREATE
    // =========================
    public function create()
    {
        return view('pelanggan.create');
    }

    // =========================
    // STORE PELANGGAN
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'no_pelanggan' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        $role = Role::where('slug', 'pelanggan')->first();

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_pelanggan' => $request->no_pelanggan,
            'password' => bcrypt($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'kecamatan' => $request->kecamatan,
            'status_akun' => $request->input('status_akun', 'aktif'),
            'role_id' => $role ? $role->id : null,
        ]);

        return redirect('/pelanggan')
                ->with('success', 'Pelanggan berhasil ditambahkan');
    }

    // =========================
    // UPDATE PELANGGAN
    // =========================
    public function update(Request $request, $id)
    {
        // validasi sebelum update, dan hindari unique conflict terhadap record sendiri
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'no_pelanggan' => 'required|unique:users,no_pelanggan,' . $id,
        ]);

        $pelanggan = User::findOrFail($id);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'no_pelanggan' => $request->no_pelanggan,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'kecamatan' => $request->kecamatan,
            'status_akun' => $request->status_akun
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $pelanggan->update($data);

        return redirect('/pelanggan')
                ->with('success', 'Data pelanggan berhasil diupdate');
    }

    // =========================
    // NONAKTIFKAN PELANGGAN
    // =========================
    public function nonaktif($id)
    {
        $pelanggan = User::where(function ($query) {
            $query->whereHas('role', function ($query) {
                $query->where('slug', 'pelanggan');
            })->orWhereNull('role_id');
        })->findOrFail($id);

        $pelanggan->update([
            'status_akun' => 'nonaktif'
        ]);

        return redirect('/pelanggan/detail/' . $id)
                ->with('success', 'Pelanggan berhasil dinonaktifkan');
    }

    // =========================
    // HAPUS PELANGGAN
    // =========================
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $pelanggan = User::where(function ($query) {
                $query->whereHas('role', function ($query) {
                    $query->where('slug', 'pelanggan');
                })->orWhereNull('role_id');
            })->findOrFail($id);

            Tagihan::where('user_id', $id)->delete();
            MeterReading::where('user_id', $id)->delete();
            Pengaduan::where('user_id', $id)->delete();

            $pelanggan->delete();
        });

        return redirect('/pelanggan')
                ->with('success', 'Pelanggan berhasil dihapus');
    }

    // =========================
    // DETEKSI ANOMALI
    // =========================
    public function anomali()
    {
        $anomali = MeterReading::where('pemakaian', '>', 100)
                                ->latest()
                                ->get();

        return response()->json([
            'status' => true,
            'data' => $anomali
        ]);
    }

    // =========================
    // EXPORT EXCEL
    // =========================
    public function exportExcel()
    {
        $pelanggan = User::where(function ($query) {
            $query->whereHas('role', function ($query) {
                $query->where('slug', 'pelanggan');
            })->orWhereNull('role_id');
        })->orderBy('id')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="pelanggan.csv"',
        ];

        $columns = ['ID', 'No Pelanggan', 'Nama', 'Email', 'No HP', 'Kecamatan', 'Status Akun', 'Created At'];

        $callback = function () use ($pelanggan, $columns) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for better Excel compatibility
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns);

            foreach ($pelanggan as $item) {
                fputcsv($file, [
                    $item->id,
                    '="' . $item->no_pelanggan . '"',
                    $item->nama,
                    $item->email,
                    '="' . ($item->no_hp ?? '') . '"',
                    $item->kecamatan,
                    $item->status_akun,
                    $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
