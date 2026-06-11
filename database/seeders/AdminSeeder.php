<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan updateOrCreate agar tidak terjadi duplikasi jika seeder dijalankan berulang kali
        User::updateOrCreate(
            ['email' => 'admin@sekolah.sch.id'], // Kondisi pencarian
            [
                'name'     => 'Administrator Sekolah',
                'password' => Hash::make('password123'), // Password default yang aman (sudah di-hash)
                'role'     => 'admin',
            ]
        );

        $this->command->info('✅ Akun Admin berhasil dibuat/diperbarui!');
        $this->command->info('📧 Email: admin@sekolah.sch.id');
        $this->command->info('🔑 Password: password123');
    }
}