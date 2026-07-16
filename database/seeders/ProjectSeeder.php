<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Data proyek diambil langsung dari portofolio CV Destria Angelyne
        Project::create([
            'title' => 'Website Sistem Informasi Puskesmas',
            'period' => '2024 – Sekarang',
            'description' => 'Mengembangkan website Sistem Informasi Puskesmas berbasis web untuk mendukung pengelolaan data layanan kesehatan.',
            'features' => ['Pengelolaan data pasien', 'Manajemen tenaga medis', 'Sistem layanan kesehatan'],
            'tags' => ['Laravel', 'MySQL', 'Tailwind CSS']
        ]);

        Project::create([
            'title' => 'Website E-Commerce Pertanian',
            'period' => '2024',
            'description' => 'Mengembangkan website e-commerce sebagai platform penjualan hasil pertanian secara daring.',
            'features' => ['Autentikasi pengguna', 'Katalog produk', 'Keranjang belanja', 'Sistem transaksi'],
            'tags' => ['Vue.js', 'PHP', 'Bootstrap']
        ]);

        Project::create([
            'title' => 'Website E-Commerce Cuci Mobil',
            'period' => '2024',
            'description' => 'Mengembangkan website e-commerce untuk layanan pemesanan dan penjualan paket pencucian mobil.',
            'features' => ['Manajemen layanan', 'Sistem pemesanan online', 'Pengelolaan data pelanggan'],
            'tags' => ['React', 'Laravel', 'MySQL']
        ]);
    }
}
