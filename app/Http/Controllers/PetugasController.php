<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Petugas;
use App\Models\Pengaduan;
use App\Models\MeterReading;
use App\Models\Tagihan;

class PetugasController extends Controller
{
    // =========================
    // LIST PETUGAS
    // =========================
    public function index(Request $request)
    {
        $petugasQuery = Petugas::query();

        if ($search = trim((string) $request->query('search', ''))) {
            $petugasQuery->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('kode_petugas', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%');
            });
        }

        if ($kecamatan = $request->query('kecamatan')) {
            $petugasQuery->where('kecamatan', $kecamatan);
        }

        if ($role = $request->query('role')) {
            if ($role === 'lapangan') {
                $petugasQuery->where(function ($query) {
                    $query->whereIn('role', ['lapangan', 'Petugas Lapangan'])
                        ->orWhereNull('role');
                });
            } else {
                $petugasQuery->whereIn('role', $this->roleFilterValues($role));
            }
        }

        if ($status = $request->query('status')) {
            $petugasQuery->whereIn('status', $this->statusFilterValues($status));
        }

        if ($device = trim((string) $request->query('device', ''))) {
            if ($device === 'terhubung') {
                $petugasQuery->whereNotNull('device_id')
                             ->where('device_id', '!=', '');
            } elseif ($device === 'belum_terhubung') {
                $petugasQuery->where(function ($query) {
                    $query->whereNull('device_id')
                          ->orWhere('device_id', '');
                });
            }
        }

        $petugas = $petugasQuery->latest()->get();

        $totalPetugas = Petugas::count();

        $petugasAktif = Petugas::where('status', 'aktif')->count();

        $petugasNonaktif = Petugas::where(function ($query) {
            $query->where('status', 'nonaktif')
                ->orWhere('status', 'blocked');
        })->count();

        $deviceTerhubung = Petugas::whereNotNull('device_id')
            ->where('device_id', '!=', '')
            ->count();

        return view('petugas.index', compact(
            'petugas',
            'totalPetugas',
            'petugasAktif',
            'petugasNonaktif',
            'deviceTerhubung'
        ));
    }

    // =========================
    // EXPORT EXCEL
    // =========================
    public function exportExcel(Request $request)
    {
        $petugasQuery = Petugas::query();

        if ($search = trim((string) $request->query('search', ''))) {
            $petugasQuery->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('kode_petugas', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%');
            });
        }

        if ($kecamatan = $request->query('kecamatan')) {
            $petugasQuery->where('kecamatan', $kecamatan);
        }

        if ($role = $request->query('role')) {
            $petugasQuery->whereIn('role', $this->roleFilterValues($role));
        }

        if ($status = $request->query('status')) {
            $petugasQuery->whereIn('status', $this->statusFilterValues($status));
        }

        if ($device = trim((string) $request->query('device', ''))) {
            if ($device === 'terhubung') {
                $petugasQuery->whereNotNull('device_id')
                             ->where('device_id', '!=', '');
            } elseif ($device === 'belum_terhubung') {
                $petugasQuery->where(function ($query) {
                    $query->whereNull('device_id')
                          ->orWhere('device_id', '');
                });
            }
        }

        $petugas = $petugasQuery->orderBy('id')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="petugas.csv"',
        ];

        $columns = ['ID', 'Kode Petugas', 'Nama', 'Email', 'No HP', 'Kecamatan', 'Role', 'Status', 'Device', 'Updated At'];

        $callback = function () use ($petugas, $columns) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns);

            foreach ($petugas as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->kode_petugas,
                    $item->nama,
                    $item->email,
                    '="' . ($item->no_hp ?? '') . '"',
                    $item->kecamatan,
                    $item->role,
                    $item->status,
                    $item->device_name ?? '-',
                    $item->updated_at ? $item->updated_at->format('Y-m-d H:i:s') : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // =========================
    // DETAIL PETUGAS
    // =========================
    public function detail($id)
    {
        $petugas = Petugas::findOrFail($id);

        $pengaduan = Pengaduan::where('petugas_id', $id)
                            ->latest()
                            ->get();

        $meter = MeterReading::where('petugas_id', $id)
                            ->latest()
                            ->get();

        return view('petugas.detail', compact(
            'petugas',
            'pengaduan',
            'meter'
        ));
    }

    // =========================
    // FORM EDIT
    // =========================
    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);

        return view('petugas.edit', compact('petugas'));
    }

    // =========================
    // FORM CREATE
    // =========================
    public function create()
    {
        return view('petugas.create');
    }

    // =========================
    // STORE PETUGAS
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'kode_petugas' => 'required|unique:petugas',
            'nama' => 'required',
            'email' => 'required|email|unique:petugas',
            'password' => 'required|min:6',
        ]);

        Petugas::create([
            'kode_petugas' => $request->kode_petugas,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_hp' => $request->no_hp,
            'kecamatan' => $request->kecamatan,
            'role' => $this->normalizeRole($request->role),
            'status' => $this->normalizeStatus($request->status, 'aktif'),
            'device_id' => null,
            'device_name' => null,
        ]);

        return redirect('/petugas')
                ->with('success', 'Petugas berhasil ditambahkan');
    }

    // =========================
    // UPDATE PETUGAS
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:petugas,email,' . $id,
            'kode_petugas' => 'required|unique:petugas,kode_petugas,' . $id,
            'password' => 'nullable|min:6',
        ]);
        
        $petugas = Petugas::findOrFail($id);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'kode_petugas' => $request->kode_petugas,
            'no_hp' => $request->no_hp,
            'kecamatan' => $request->kecamatan,
            'role' => $this->normalizeRole($request->role),
            'status' => $this->normalizeStatus($request->status, $petugas->status)
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $petugas->update($data);

        return redirect('/petugas')
                ->with('success', 'Data petugas berhasil diupdate');
    }

    // =========================
    // HAPUS PETUGAS
    // =========================
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $petugas = Petugas::findOrFail($id);

            Pengaduan::where('petugas_id', $id)->update(['petugas_id' => null]);
            MeterReading::where('petugas_id', $id)->update(['petugas_id' => null]);

            $petugas->delete();
        });

        return redirect('/petugas')
                ->with('success', 'Petugas berhasil dihapus');
    }

    // =========================
    // RESET DEVICE LOGIN
    // =========================
    public function resetDevice($id)
    {
        $petugas = Petugas::findOrFail($id);

        $petugas->update([
            'device_id' => null,
            'device_name' => null,
        ]);

        return redirect('/petugas/detail/' . $id)
                ->with('success', 'Device berhasil direset');
    }

    // =========================
    // BLOKIR PETUGAS
    // =========================
    public function block($id)
    {
        $petugas = Petugas::findOrFail($id);

        $petugas->update([
            'status' => 'blocked'
        ]);

        return redirect('/petugas')
                ->with('success', 'Petugas berhasil diblokir');
    }

    // =========================
    // NONAKTIFKAN PETUGAS
    // =========================
    public function nonaktif($id)
    {
        $petugas = Petugas::findOrFail($id);

        $petugas->update([
            'status' => 'nonaktif'
        ]);

        return redirect('/petugas/detail/' . $id)
                ->with('success', 'Petugas berhasil dinonaktifkan');
    }

    public function apiLogin(Request $request)
    {
        $request->validate([
            'kode_petugas' => 'required',
            'password' => 'required',
            'device_id' => 'nullable',
            'device_name' => 'nullable',
        ]);

        $petugas = Petugas::where('kode_petugas', $request->kode_petugas)
            ->orWhere('email', $request->kode_petugas)
            ->first();

        if (!$petugas || !Hash::check($request->password, $petugas->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Kode petugas atau password salah'
            ], 401);
        }

        if ($petugas->status != 'aktif') {
            return response()->json([
                'status' => false,
                'message' => 'Akun petugas tidak aktif'
            ], 403);
        }

        if ($petugas->device_id && $request->device_id && $petugas->device_id != $request->device_id) {
            return response()->json([
                'status' => false,
                'message' => 'Akun ini sudah digunakan di device lain'
            ], 403);
        }

        if (!$petugas->device_id && $request->device_id) {
            $petugas->update([
                'device_id' => $request->device_id,
                'device_name' => $request->device_name,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Login petugas berhasil',
            'data' => $petugas
        ]);
    }

    public function apiMeter($petugas_id)
    {
        $petugas = Petugas::findOrFail($petugas_id);

        $meter = MeterReading::with('user')
            ->whereHas('user', function ($q) use ($petugas) {
                $q->where('kecamatan', $petugas->kecamatan);
            })
            ->where('status', 'pending')
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data meter pending berhasil diambil',
            'data' => $meter
        ]);
    }

    public function apiValidasiMeter($id)
    {
        $meter = MeterReading::findOrFail($id);

        $meter->update([
            'status' => 'valid',
            'validasi_petugas' => 'valid',
            'status_anomali' => 'normal',
            'petugas_id' => request('petugas_id'),
        ]);

        // Cari atau buat tagihan jika pemakaian > 0
        if ($meter->pemakaian > 0) {
            $cekTagihan = Tagihan::where('meter_id', $meter->id)->first();
            if (!$cekTagihan) {
                $bulanAngka = [
                    'Januari'   => 1,
                    'Februari'  => 2,
                    'Maret'     => 3,
                    'April'     => 4,
                    'Mei'       => 5,
                    'Juni'      => 6,
                    'Juli'      => 7,
                    'Agustus'   => 8,
                    'September' => 9,
                    'Oktober'   => 10,
                    'November'  => 11,
                    'Desember'  => 12,
                ];

                $bulan = $meter->bulan;
                $tahun = $meter->tahun;
                $bulanIdx = $bulanAngka[$bulan] ?? 1;

                $jatuhTempo = \Carbon\Carbon::create($tahun, $bulanIdx, 20)->addMonth();

                Tagihan::create([
                    'user_id'        => $meter->user_id,
                    'meter_id'       => $meter->id,
                    'bulan'          => $bulan,
                    'tahun'          => $tahun,
                    'periode'        => $bulan . ' ' . $tahun,
                    'pemakaian'      => $meter->pemakaian,
                    'total_tagihan'  => $meter->pemakaian * 4000,
                    'tarif_per_m3'   => 4000,
                    'invoice_number' => null, // Baru dibuat ketika user klik bayar
                    'status'         => 'belum_bayar',
                    'jatuh_tempo'    => $jatuhTempo
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Meter berhasil divalidasi',
            'data' => $meter
        ]);
    }

    public function apiWarningMeter($id)
    {
        $meter = MeterReading::findOrFail($id);

        $meter->update([
            'status' => 'pending',
            'status_anomali' => 'anomali',
            'validasi_petugas' => 'warning',
            'catatan_anomali' => request('catatan_anomali') ?? 'Pemakaian tidak normal',
            'petugas_id' => request('petugas_id'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Meter ditandai warning',
            'data' => $meter
        ]);
    }

    public function apiPengaduan($petugas_id)
    {
        $petugas = Petugas::findOrFail($petugas_id);

        $pengaduan = Pengaduan::with('user')
            ->whereHas('user', function ($q) use ($petugas) {
                $q->where('kecamatan', $petugas->kecamatan);
            })
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data pengaduan berhasil diambil',
            'data' => $pengaduan
        ]);
    }

    public function apiUpdatePengaduan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'petugas_id' => 'required',
            'foto_bukti' => 'nullable|image|max:5120',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        $updateData = [
            'status' => $request->status,
            'petugas_id' => $request->petugas_id,
            'catatan_petugas' => $request->catatan_petugas,
        ];

        if ($request->status == 'selesai') {
            $updateData['tanggal_selesai'] = now();
            if ($request->hasFile('foto_bukti')) {
                $updateData['foto_bukti'] = $request->file('foto_bukti')->store('bukti_pengaduan', 'public');
            }
        }

        $pengaduan->update($updateData);

        return response()->json([
            'status' => true,
            'message' => 'Status pengaduan berhasil diperbarui',
            'data' => $pengaduan
        ]);
    }

    public function apiDashboard($petugas_id)
    {
        $petugas = Petugas::findOrFail($petugas_id);

        $pendingMeter = MeterReading::whereHas('user', function ($q) use ($petugas) {
            $q->where('kecamatan', $petugas->kecamatan);
        })->where('status', 'pending')->count();

        $validMeter = MeterReading::whereHas('user', function ($q) use ($petugas) {
            $q->where('kecamatan', $petugas->kecamatan);
        })->where('status', 'valid')->count();

        $anomaliMeter = MeterReading::whereHas('user', function ($q) use ($petugas) {
            $q->where('kecamatan', $petugas->kecamatan);
        })->where('status_anomali', 'anomali')->count();

        $pengaduanMasuk = Pengaduan::whereHas('user', function ($q) use ($petugas) {
            $q->where('kecamatan', $petugas->kecamatan);
        })->where('status', 'pending')->count();

        $pengaduanProses = Pengaduan::whereHas('user', function ($q) use ($petugas) {
            $q->where('kecamatan', $petugas->kecamatan);
        })->where('status', 'proses')->count();

        $pengaduanSelesai = Pengaduan::whereHas('user', function ($q) use ($petugas) {
            $q->where('kecamatan', $petugas->kecamatan);
        })->where('status', 'selesai')->count();

        return response()->json([
            'status' => true,
            'message' => 'Data dashboard petugas berhasil diambil',
            'data' => [
                'pending_meter' => $pendingMeter,
                'valid_meter' => $validMeter,
                'anomali_meter' => $anomaliMeter,
                'pengaduan_masuk' => $pengaduanMasuk,
                'pengaduan_proses' => $pengaduanProses,
                'pengaduan_selesai' => $pengaduanSelesai,
            ]
        ]);
    }

    public function apiMeterDetail($meter_id)
    {
        $meter = MeterReading::with('user')->findOrFail($meter_id);

        return response()->json([
            'status' => true,
            'message' => 'Detail data meter berhasil diambil',
            'data' => $meter
        ]);
    }

    public function apiMeterHistory($petugas_id)
    {
        $meter = MeterReading::with('user')
            ->where('petugas_id', $petugas_id)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Riwayat validasi petugas berhasil diambil',
            'data' => $meter
        ]);
    }

    public function apiPengaduanDetail($pengaduan_id)
    {
        $pengaduan = Pengaduan::with('user')->findOrFail($pengaduan_id);

        return response()->json([
            'status' => true,
            'message' => 'Detail pengaduan berhasil diambil',
            'data' => $pengaduan
        ]);
    }

    public function apiGangguan($petugas_id)
    {
        $petugas = Petugas::findOrFail($petugas_id);

        $gangguan = DB::table('gangguan_air')
            ->where('kecamatan', $petugas->kecamatan)
            ->where('status', '!=', 'selesai')
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data gangguan air berhasil diambil',
            'data' => $gangguan
        ]);
    }

    public function apiProfile($petugas_id)
    {
        $petugas = Petugas::findOrFail($petugas_id);

        return response()->json([
            'status' => true,
            'message' => 'Profil petugas berhasil diambil',
            'data' => $petugas
        ]);
    }

    // =========================
    // NORMALISASI ROLE
    // =========================
    private function normalizeRole(?string $role): ?string
    {
        return match ($role) {
            'supervisor', 'Supervisor Cabang' => 'supervisor',
            'customer_service', 'Customer Service', 'Petugas Pengaduan' => 'customer_service',
            default => 'lapangan',
        };
    }

    // =========================
    // NORMALISASI STATUS
    // =========================
    private function normalizeStatus(?string $status, string $default = 'aktif'): string
    {
        return match ($status) {
            'aktif', 'Aktif' => 'aktif',
            'nonaktif', 'Nonaktif' => 'nonaktif',
            'blocked', 'Blocked' => 'blocked',
            default => $default,
        };
    }

    // =========================
    // FILTER ROLE
    // =========================
    private function roleFilterValues(string $role): array
    {
        return match ($role) {
            'supervisor' => ['supervisor', 'Supervisor Cabang'],
            'customer_service' => ['customer_service', 'Customer Service', 'Petugas Pengaduan'],
            'lapangan' => ['lapangan', 'Petugas Lapangan', null],
            default => [$role],
        };
    }

    // =========================
    // FILTER STATUS
    // =========================
    private function statusFilterValues(string $status): array
    {
        return match ($status) {
            'aktif' => ['aktif', 'Aktif'],
            'nonaktif' => ['nonaktif', 'Nonaktif'],
            'blocked' => ['blocked', 'Blocked'],
            default => [$status],
        };
    }
}
