<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\KategoriSurat;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // -------------------------------------------------------
        // Users
        // -------------------------------------------------------
        User::create([
            'nama_lengkap' => 'Admin Tata Usaha',
            'username'     => 'admin_tu',
            'password'     => Hash::make('password'),
            'role'         => 'admin_tu',
        ]);

        User::create([
            'nama_lengkap' => 'Kepala Sekolah',
            'username'     => 'kepsek',
            'password'     => Hash::make('password'),
            'role'         => 'kepala_sekolah',
        ]);

        // -------------------------------------------------------
        // Kategori Surat
        // -------------------------------------------------------
        $kategori = [
            'Surat Izin / Sakit',
            'Surat Cuti',
            'Surat Pengantar',
            'Surat Edaran',
            'Surat Keterangan',
            'Surat Permohonan',
            'Surat Undangan Rapat',
            'Surat Keputusan',
            'Surat Pemberitahuan',
            'Lainnya',
        ];

        foreach ($kategori as $nama) {
            KategoriSurat::create(['nama_kategori' => $nama]);
        }
    }
}
