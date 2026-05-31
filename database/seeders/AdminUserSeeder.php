<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user if not exists
        if (!User::where('email', 'admin@pdam.com')->exists()) {
            $role = Role::where('slug', 'admin')->first();

            User::create([
                'no_pelanggan' => '000000',
                'nama' => 'Admin PDAM',
                'email' => 'admin@pdam.com',
                'password' => Hash::make('admin123'),
                'role_id' => $role ? $role->id : null,
                'no_hp' => '081234567890',
                'alamat' => 'Kantor Pusat PDAM',
                'kecamatan' => 'Kecamatan',
                'latitude' => null,
                'longitude' => null,
                'status_akun' => 'aktif',
            ]);
        }
    }
}
