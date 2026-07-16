<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SocialLink;
use App\Models\SoftSkill;
use App\Models\Technology;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Data di bawah ini disalin persis dari refs di Home.vue,
     * supaya pas dipindah ke database, tampilan web TIDAK berubah.
     */
    public function run(): void
    {
        // ---- Profil (singleton, 1 baris) ----
        Profile::updateOrCreate(
            ['email' => 'angelynedestria@gmail.com'],
            [
                'name' => 'Destria Angelyne',
                'school' => 'SMK Negeri 2 Surabaya',
                'major' => 'Rekayasa Perangkat Lunak',
                'location' => 'Surabaya, Jawa Timur',
                'phone' => '+62 859-1717-76488',
                'summary' => 'Saya adalah siswa SMKN 2 Surabaya jurusan Rekayasa Perangkat Lunak yang memiliki minat pada pengembangan aplikasi web modern. Terbiasa menggunakan Laravel, Vue.js, dan MySQL untuk membangun aplikasi web dengan kode yang terstruktur dan antarmuka yang responsif.',
                'cv_file_path' => null, // isi manual kalau file CV sudah di-upload ke storage
            ]
        );

        // ---- Pendidikan (timeline) ----
        $educations = [
            ['period' => '2024 – Sekarang', 'school' => 'SMK Negeri 2 Surabaya', 'major' => 'Rekayasa Perangkat Lunak', 'order' => 1],
            ['period' => '2021 – 2024', 'school' => 'SMP Negeri 20 Surabaya', 'major' => null, 'order' => 2],
            ['period' => '2016 – 2021', 'school' => 'SD Negeri Manukan Kulon II/499', 'major' => null, 'order' => 3],
        ];
        foreach ($educations as $edu) {
            Education::updateOrCreate(['school' => $edu['school']], $edu);
        }

        // ---- Technologies: row 1 (frontend) ----
        // icon_key di sini HARUS cocok dengan slug resmi Simple Icons
        // (dipakai lewat https://cdn.simpleicons.org/{icon_key}).
        //
        // PENTING: updateOrCreate() cuma insert/update baris yang namanya
        // cocok di array di bawah — baris LAMA yang udah gak ada di sini
        // (misal sisa percobaan "React" atau "PostgreSQL" dari iterasi
        // sebelumnya) TIDAK ikut kehapus otomatis dan tetap muncul di
        // marquee. Makanya kita hapus dulu semua row yang gak termasuk
        // daftar final sebelum insert ulang.
        $techFrontend = [
            ['name' => 'Vue.js', 'icon_key' => 'vuedotjs', 'icon_source' => 'simpleicons', 'color' => '#42b883', 'order' => 1],
            ['name' => 'JavaScript', 'icon_key' => 'javascript', 'icon_source' => 'simpleicons', 'color' => '#f0db4f', 'order' => 2],
            ['name' => 'TypeScript', 'icon_key' => 'typescript', 'icon_source' => 'simpleicons', 'color' => '#3178c6', 'order' => 3],
            ['name' => 'Tailwind CSS', 'icon_key' => 'tailwindcss', 'icon_source' => 'simpleicons', 'color' => '#38bdf8', 'order' => 4],
            ['name' => 'Inertia.js', 'icon_key' => 'inertia', 'icon_source' => 'simpleicons', 'color' => '#9553e9', 'order' => 5],
            ['name' => 'HTML5', 'icon_key' => 'html5', 'icon_source' => 'simpleicons', 'color' => '#e34f26', 'order' => 6],
            ['name' => 'Node.js', 'icon_key' => 'nodedotjs', 'icon_source' => 'simpleicons', 'color' => '#339933', 'order' => 7],
        ];
        foreach ($techFrontend as $tech) {
            Technology::updateOrCreate(
                ['name' => $tech['name']],
                array_merge($tech, ['category' => 'frontend'])
            );
        }

        // Hapus row frontend lama yang gak ada lagi di daftar final
        // (contoh: "React" sisa percobaan sebelum pindah ke Vue.js).
        Technology::where('category', 'frontend')
            ->whereNotIn('name', collect($techFrontend)->pluck('name'))
            ->delete();

        // ---- Technologies: row 2 (backend & tools) ----
        // Composer & npm dihapus dari daftar. Bootstrap dihapus juga.
        // VS Code pakai icon_source 'devicon' karena logo aslinya sudah
        // ditarik dari Simple Icons (masalah trademark Microsoft) —
        // lihat helper techIconUrl() di Home.vue.
        $techBackend = [
            ['name' => 'Laravel', 'icon_key' => 'laravel', 'icon_source' => 'simpleicons', 'color' => '#ff2d20', 'order' => 1],
            ['name' => 'PHP', 'icon_key' => 'php', 'icon_source' => 'simpleicons', 'color' => '#8892be', 'order' => 2],
            ['name' => 'MySQL', 'icon_key' => 'mysql', 'icon_source' => 'simpleicons', 'color' => '#00758f', 'order' => 3],
            ['name' => 'Git', 'icon_key' => 'git', 'icon_source' => 'simpleicons', 'color' => '#f05032', 'order' => 4],
            ['name' => 'GitHub', 'icon_key' => 'github', 'icon_source' => 'simpleicons', 'color' => '#ffffff', 'order' => 5],
            ['name' => 'Figma', 'icon_key' => 'figma', 'icon_source' => 'simpleicons', 'color' => '#a259ff', 'order' => 6],
            ['name' => 'VS Code', 'icon_key' => 'vscode', 'icon_source' => 'devicon', 'color' => '#007acc', 'order' => 7],
            ['name' => 'Vite', 'icon_key' => 'vite', 'icon_source' => 'simpleicons', 'color' => '#646cff', 'order' => 8],
            ['name' => 'Postman', 'icon_key' => 'postman', 'icon_source' => 'simpleicons', 'color' => '#ff6c37', 'order' => 9],
            ['name' => 'XAMPP', 'icon_key' => 'xampp', 'icon_source' => 'simpleicons', 'color' => '#fb7a24', 'order' => 10],
        ];
        foreach ($techBackend as $tech) {
            Technology::updateOrCreate(
                ['name' => $tech['name']],
                array_merge($tech, ['category' => 'backend'])
            );
        }

        // Hapus row backend lama yang gak ada lagi di daftar final
        // (contoh: "PostgreSQL" sisa percobaan sebelum pindah ke MySQL,
        // "Composer"/"npm" yang udah sengaja di-drop, dst).
        Technology::where('category', 'backend')
            ->whereNotIn('name', collect($techBackend)->pluck('name'))
            ->delete();

        // ---- Portofolio Proyek (section #projects) ----
        // Cuma 2 proyek yang ditampilkan: Sistem Informasi Puskesmas dan
        // AgriNova. Proyek E-Commerce Cuci Mobil sengaja tidak dimasukkan
        // karena belum dilanjutkan pengembangannya.
        //
        // 'image' sudah diisi path relatif menuju file yang ditaruh di
        // storage/app/public/projects/. Home.vue mengaksesnya lewat
        // /storage/{image} (symbolic link storage sudah aktif).
        $projects = [
            [
                'title' => 'Sistem Informasi Puskesmas',
                'description' => 'Sistem antrian digital untuk klinik kesehatan masyarakat (Puskesmas), mendukung pendaftaran online multi-langkah dan empat peran berbeda: Admin, Loket, Perawat, dan Pasien.',
                'tags' => ['Laravel', 'Vue 3', 'TypeScript', 'Pinia', 'MySQL', 'REST API'],
                'features' => [
                    'Pendaftaran antrian online 5 langkah',
                    'Manajemen multi-role (Admin, Loket, Perawat, Pasien)',
                    'Tampilan tiket antrian real-time',
                    'REST API terpisah dari frontend SPA',
                ],
                'image' => 'projects/puskesmas.png',
            ],
            [
                'title' => 'AgriNova',
                'description' => 'Platform e-commerce agritech bertema gelap untuk penjualan produk pertanian, lengkap dengan katalog produk, artikel edukasi, dan sistem kategori.',
                'tags' => ['Laravel', 'Inertia.js', 'Vue 3', 'Tailwind CSS', 'MySQL'],
                'features' => [
                    'Katalog 25 produk dalam 5 kategori',
                    'Halaman artikel edukasi pertanian',
                    'Navbar sticky dengan pencarian & dropdown kategori',
                    'Desain dark theme hijau tua & lime',
                ],
                'image' => 'projects/agrinova.png',
            ],
        ];
        foreach ($projects as $project) {
            Project::updateOrCreate(['title' => $project['title']], $project);
        }

        // Hapus proyek lama yang gak ada lagi di daftar final
        // (misal E-Commerce Cuci Mobil yang sengaja tidak dilanjutkan).
        Project::whereNotIn('title', collect($projects)->pluck('title'))->delete();

        // ---- Keahlian Dasar / Soft Skills ----
        $softSkills = [
            ['title' => 'Communication', 'description' => 'Mampu berkomunikasi dengan baik dalam berbagai situasi.', 'order' => 1],
            ['title' => 'Teamwork', 'description' => 'Mampu bekerja sama dengan tim untuk mencapai tujuan bersama.', 'order' => 2],
            ['title' => 'Problem Solving', 'description' => 'Berpikir secara sistematis dan terstruktur dalam pemecahan masalah.', 'order' => 3],
        ];
        foreach ($softSkills as $skill) {
            SoftSkill::updateOrCreate(['title' => $skill['title']], $skill);
        }

        // ---- Social Links (footer) ----
        // LinkedIn & Instagram sengaja dihapus, cuma nyisain GitHub.
        $socialLinks = [
            ['platform' => 'github', 'url' => 'https://github.com/DestriaAngelyne', 'icon_key' => 'github', 'order' => 1],
        ];
        foreach ($socialLinks as $link) {
            SocialLink::updateOrCreate(['platform' => $link['platform']], $link);
        }

        // Hapus social link lama yang gak ada lagi di daftar final
        // (LinkedIn & Instagram yang sengaja di-drop).
        SocialLink::whereNotIn('platform', collect($socialLinks)->pluck('platform'))->delete();
    }
}
