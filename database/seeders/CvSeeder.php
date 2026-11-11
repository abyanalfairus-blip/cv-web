<?php

namespace Database\Seeders;

use App\Models\Profil;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Mengisi database dengan data CV Abyan Alfairus.
 *
 * Jalankan:  php artisan migrate:fresh --seed
 *
 * Seeder hanya dipakai untuk isi awal. Setelah itu data bisa diubah
 * langsung di database (phpMyAdmin / HeidiSQL di Laragon) dan halaman
 * akan ikut berubah tanpa mengedit kode.
 */
class CvSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            /* ---------------- 1. Profil ---------------- */
            $profil = Profil::create([
                'nama'           => 'Abyan Alfairus',
                'nama_judul_1'   => 'ABYAN',
                'nama_judul_2'   => 'ALFAIRUS',
                'pre_judul'      => 'UMMI · TEKNIK INFORMATIKA · 2026',
                'subjudul'       => 'Web Developer Berbasis Framework — Curriculum Vitae Edition',
                'kelas_karakter' => 'Fullstack Builder · Laravel × Kotlin',
                'ringkasan'      => 'Mahasiswa **semester 6 Teknik Informatika** di Universitas Muhammadiyah Sukabumi. '
                    . 'Membangun aplikasi web dengan **Laravel** dan aplikasi Android dengan **Kotlin**, '
                    . 'terbiasa bekerja dalam tim lewat GitHub, merancang sistem dengan class diagram sebelum '
                    . 'menulis kode, dan menyiapkan dokumentasi serta presentasi untuk setiap proyek.',
                'email'          => 'abyanalfairus@gmail.com',
                'domisili'       => 'Sukabumi, Jawa Barat',
                'ajakan'         => 'Terbuka untuk magang, proyek web dan Android, atau kolaborasi game. Domisili Sukabumi, Jawa Barat. Pilih jalur komunikasi:',
                'footer'         => '© 2026 ABYAN ALFAIRUS · GAME OVER? TIDAK, BARU MULAI.',
            ]);

            /* ---------------- 2. Kontak ---------------- */
            $profil->kontak()->createMany($this->urut([
                ['label' => 'WhatsApp', 'ikon' => 'WA',  'teks' => '0856-9377-4175',                           'url' => 'https://wa.me/6285693774175'],
                ['label' => 'Email',    'ikon' => '@',   'teks' => 'abyanalfairus@gmail.com',                  'url' => 'mailto:abyanalfairus@gmail.com'],
                ['label' => 'GitHub',   'ikon' => '</>', 'teks' => 'github.com/abyanalfairus-blip',            'url' => 'https://github.com/abyanalfairus-blip'],
                ['label' => 'LinkedIn', 'ikon' => 'in',  'teks' => 'linkedin.com/in/abyan-alfairus-a417102b4', 'url' => 'https://www.linkedin.com/in/abyan-alfairus-a417102b4'],
            ]));

            /* ---------------- 3. Pendidikan + mata kuliah ---------------- */
            $kuliah = $profil->pendidikan()->create([
                'institusi'         => 'Universitas Muhammadiyah Sukabumi',
                'jenjang'           => 'S1',
                'jurusan'           => 'Teknik Informatika',
                'semester_saat_ini' => 6,
                'total_semester'    => 8,
                'status'            => 'berjalan',
                'urutan'            => 1,
            ]);
            $kuliah->mataKuliah()->createMany($this->urut([
                ['nama' => 'Pemrograman Web',             'keterangan' => 'PHP, Laravel'],
                ['nama' => 'Pemrograman Mobile',          'keterangan' => 'Kotlin, Android'],
                ['nama' => 'Perancangan Perangkat Lunak', 'keterangan' => 'Prinsip SOLID'],
                ['nama' => 'Kompleksitas Algoritma',      'keterangan' => 'Big-O, greedy'],
                ['nama' => 'Kecerdasan Buatan',           'keterangan' => 'Algoritma pencarian'],
                ['nama' => 'Pengolahan Citra Digital',    'keterangan' => 'Python, OpenCV'],
            ]));

            $profil->pendidikan()->create([
                'institusi' => 'SMA Negeri 1 Palabuhanratu',
                'jenjang'   => 'SMA',
                'jurusan'   => 'IPA',
                'status'    => 'lulus',
                'urutan'    => 2,
            ]);

            /* ---------------- 4. Kategori skill + skill ---------------- */
            $skillTree = [
                ['nama' => 'WEB', 'kode' => 'WEB', 'warna' => 'hp', 'skill' => [
                    'PHP'              => null,
                    'Laravel'          => null,
                    'Blade & HTML/CSS' => null,
                    'MySQL'            => null,
                ]],
                ['nama' => 'MOBILE', 'kode' => 'MOB', 'warna' => 'mp', 'skill' => [
                    'Kotlin'            => null,
                    'Jetpack Compose'   => null,
                    'MVVM & Navigation' => null,
                ]],
                ['nama' => 'ALGORITMA & AI', 'kode' => 'ALG', 'warna' => 'xp', 'skill' => [
                    'Python'     => null,
                    'BFS & Graf' => null,
                    'OpenCV'     => null,
                ]],
                ['nama' => 'DESAIN SISTEM', 'kode' => 'SYS', 'warna' => 'gold', 'skill' => [
                    'UML Class Diagram' => null,
                    'OOP & SOLID'       => 'Mata kuliah Perancangan Perangkat Lunak',
                    'Analisis Big-O'    => null,
                ]],
            ];

            $skill = []; // nama skill => model, untuk dihubungkan ke pengalaman
            foreach ($skillTree as $i => $cabang) {
                $kategori = $profil->kategoriSkill()->create([
                    'nama'   => $cabang['nama'],
                    'kode'   => $cabang['kode'],
                    'warna'  => $cabang['warna'],
                    'urutan' => $i + 1,
                ]);
                $j = 0;
                foreach ($cabang['skill'] as $nama => $keterangan) {
                    $skill[$nama] = $kategori->skill()->create([
                        'nama'       => $nama,
                        'keterangan' => $keterangan,
                        'urutan'     => ++$j,
                    ]);
                }
            }

            /* ---------------- 5. Pengalaman + poin + skill ---------------- */
            $pengalaman = [
                [
                    'jenis' => 'kerja', 'label_quest' => 'MAIN QUEST', 'utama' => true, 'status' => 'berjalan',
                    'judul' => 'Kerja Praktik: Website Donasi Yayasan Griya Bina Yamuti', 'singkatan' => 'KP',
                    'instansi' => 'Yayasan Griya Bina Yamuti', 'periode' => '2026 – sekarang',
                    'poin' => [
                        'Membangun website donasi untuk yayasan (griyabinayamuti.or.id) dengan Laravel 12.',
                        'Menerjemahkan kebutuhan yayasan menjadi tampilan dan alur donasi yang mengacu pada platform donasi daring populer.',
                        'Berkolaborasi dengan rekan satu tim lewat repositori GitHub; pengembangan lokal di Laragon.',
                    ],
                    'skill' => ['PHP', 'Laravel', 'Blade & HTML/CSS'],
                ],
                [
                    'jenis' => 'proyek', 'label_quest' => 'BOSS RAID', 'status' => 'selesai',
                    'judul' => 'SIGAAP SMK1 & SIG-APP', 'singkatan' => 'SIGAAP',
                    'instansi' => 'SMKN 1 Kota Sukabumi',
                    'deskripsi' => 'Sistem informasi sekolah dua sisi: panel web Laravel yang terhubung dengan aplikasi Android. Sisi Android memakai arsitektur MVVM, layar Jetpack Compose, dan navigation routing. Termasuk class diagram dan dokumentasi sistem.',
                    'skill' => ['PHP', 'Laravel', 'Blade & HTML/CSS', 'Kotlin', 'Jetpack Compose', 'MVVM & Navigation', 'UML Class Diagram'],
                ],
                [
                    'jenis' => 'proyek', 'label_quest' => 'QUEST', 'status' => 'selesai',
                    'judul' => 'Bootcamp Microsite', 'singkatan' => 'Bootcamp Microsite',
                    'instansi' => 'Bootcamp',
                    'deskripsi' => 'Microsite donasi bergaya link-in-bio dengan halaman publik dan panel admin untuk mengelola tautan donasi.',
                    'url_kode' => 'https://github.com/abyanalfairus-blip/microsite',
                    'skill' => ['PHP', 'Laravel', 'Blade & HTML/CSS'],
                ],
                [
                    'jenis' => 'proyek', 'label_quest' => 'QUEST', 'status' => 'selesai',
                    'judul' => 'FutsalMatch', 'singkatan' => 'FutsalMatch',
                    'instansi' => 'Pemrograman Web',
                    'deskripsi' => 'Sistem manajemen turnamen untuk kegiatan futsal UMMI 2026, lengkap dengan komentar per fitur dan pemetaan fitur ke baris kode untuk sidang presentasi.',
                    'skill' => ['PHP', 'MySQL'],
                ],
                [
                    'jenis' => 'proyek', 'label_quest' => 'PARTY QUEST', 'status' => 'selesai',
                    'judul' => 'Pencarian Rute Fotokopi', 'singkatan' => 'Rute fotokopi',
                    'instansi' => 'Kecerdasan Buatan',
                    'deskripsi' => 'Bersama Kelompok 3, membangun sistem pencarian rute ke tempat fotokopi dan percetakan di sekitar kampus UMMI dengan algoritma Breadth-First Search.',
                    'skill' => ['BFS & Graf'],
                ],
                [
                    'jenis' => 'proyek', 'label_quest' => 'QUEST', 'status' => 'selesai',
                    'judul' => 'Algoritma Greedy & Big-O', 'singkatan' => 'Greedy',
                    'instansi' => 'Kompleksitas Algoritma',
                    'deskripsi' => 'Coin change, activity selection, dan MST Kruskal dengan Union-Find dalam satu program Python, plus analisis Boyer-Moore Voting dan faktorial iteratif vs rekursif.',
                    'skill' => ['Python', 'Analisis Big-O'],
                ],
                [
                    'jenis' => 'praktikum', 'label_quest' => 'SIDE QUEST', 'status' => 'berjalan',
                    'judul' => 'Praktikum Citra Digital', 'singkatan' => 'Praktikum citra',
                    'instansi' => 'Pengolahan Citra Digital',
                    'deskripsi' => 'Praktikum mingguan pengolahan citra dengan Python dan OpenCV, dikerjakan berpasangan sepanjang semester ganjil 2026/2027.',
                    'skill' => ['Python', 'OpenCV'],
                ],
            ];

            foreach ($pengalaman as $i => $data) {
                $poin = $data['poin'] ?? [];
                $pakai = $data['skill'] ?? [];
                unset($data['poin'], $data['skill']);

                $p = $profil->pengalaman()->create($data + ['urutan' => $i + 1]);

                $p->poin()->createMany(
                    $this->urut(array_map(fn ($isi) => ['isi' => $isi], $poin))
                );
                $p->skill()->attach(collect($pakai)->map(fn ($n) => $skill[$n]->id));
            }

            /* ---------------- 6. Peralatan (inventory) ---------------- */
            $profil->peralatan()->createMany($this->urut([
                ['ikon' => '</>', 'nama' => 'Git',     'keterangan' => 'Version control'],
                ['ikon' => '⇅',   'nama' => 'GitHub',  'keterangan' => 'Push & pull tim'],
                ['ikon' => '▣',   'nama' => 'Laragon', 'keterangan' => 'Server lokal'],
                ['ikon' => '◇',   'nama' => 'draw.io', 'keterangan' => 'Diagram UML'],
                ['ikon' => '◉',   'nama' => 'OpenCV',  'keterangan' => 'Olah citra'],
                ['ikon' => '▤',   'nama' => 'MySQL',   'keterangan' => 'Basis data'],
            ]));

            /* ---------------- 7. Pencapaian (achievement) ---------------- */
            $profil->pencapaian()->createMany($this->urut([
                ['ikon' => '★', 'judul' => 'DUA DUNIA',       'keterangan' => 'Membangun sistem web Laravel dan aplikasi Android yang saling terhubung.'],
                ['ikon' => '♥', 'judul' => 'PAHLAWAN DONASI', 'keterangan' => 'Dua platform donasi: Bootcamp Microsite dan website Griya Bina Yamuti.'],
                ['ikon' => '⇅', 'judul' => 'CO-OP MODE',      'keterangan' => 'Proyek tim dikelola lewat GitHub bersama rekan.'],
                ['ikon' => '◇', 'judul' => 'ARSITEK',         'keterangan' => 'Merancang class diagram dan dokumentasi sebelum menulis kode.'],
                ['ikon' => '➜', 'judul' => 'PATHFINDER',      'keterangan' => 'Menemukan rute fotokopi terdekat dengan BFS.'],
            ]));

            /* ---------------- 8. Sertifikat (loot) ---------------- */
            $profil->sertifikat()->createMany($this->urut([
                [
                    'judul' => 'Intro to Data Analytics', 'penerbit' => 'RevoU · PT Revolusi Cita Edukasi',
                    'jenis' => 'KURSUS', 'kelangkaan' => 'epic',
                    'keterangan' => 'Kursus online bersertifikat selama 1 minggu.',
                    'tanggal' => '2026-04-17', 'nomor' => 'DAMC-130426-01-1-00383',
                    'file' => 'sertifikat/revou-intro-data-analytics.pdf',
                ],
                [
                    'judul' => 'International Seminar: Empowering Education in the Digital Era',
                    'penerbit' => 'Universitas Muhammadiyah Sukabumi', 'peran' => 'Peserta',
                    'jenis' => 'SEMINAR', 'kelangkaan' => 'rare',
                    'keterangan' => 'Leadership, Global Research, and Technological Innovation.',
                    'tanggal' => '2025-11-28', 'nomor' => '3713/I.0/C/2025',
                    'file' => 'sertifikat/seminar-internasional-ummi-2025.pdf',
                ],
                [
                    'judul' => 'Membangun Generasi Unggul dan Religius',
                    'penerbit' => 'Universitas Muhammadiyah Sukabumi', 'peran' => 'Peserta',
                    'jenis' => 'KULIAH UMUM', 'kelangkaan' => 'common',
                    'keterangan' => 'Kegiatan kuliah umum tingkat universitas.',
                    'tanggal' => '2024-10-07', 'nomor' => '3122/I.0/C/2024',
                    'file' => 'sertifikat/kuliah-umum-ummi-2024.pdf',
                ],
            ]));
        });
    }

    /** Menambahkan kolom `urutan` 1, 2, 3, ... sesuai urutan array. */
    private function urut(array $baris): array
    {
        return array_map(
            fn ($data, $i) => $data + ['urutan' => $i + 1],
            $baris,
            array_keys($baris)
        );
    }
}
