<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Administrator', 'slug' => 'admin', 'description' => 'Full access to the application'],
            ['name' => 'Pelanggan', 'slug' => 'pelanggan', 'description' => 'Customer / end user'],
            ['name' => 'Petugas', 'slug' => 'petugas', 'description' => 'Field officer / staff'],
        ];

        foreach ($roles as $r) {
            Role::updateOrCreate(['slug' => $r['slug']], $r);
        }
    }
}
