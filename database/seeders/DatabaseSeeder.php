<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Achievement;
use App\Models\Category;
use App\Models\PointRule;
use App\Models\ActivityLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin
        $admin = User::firstOrCreate(
            ['email' => 'lawliet@gmail.com'],
            [
                'name' => 'Admin Sekolah',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'student_number' => '122213',
                'class_name' => 'Administrator',
                'profile_visibility' => 'public',
            ]
        );

        // Pastikan role admin & password ter-update
        $admin->update([
            'role' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // 2. Akun Siswa
        $studentsData = [
            [
                'name' => 'Ashley Siburian',
                'email' => 'alicia@gmail.com',
                'username' => 'ashley',
                'student_number' => '1234561',
                'class_name' => 'XI PPLG',
            ],
            [
                'name' => 'Alicia Zahra',
                'email' => 'alicia.zahra@achievo.test',
                'username' => 'alicia',
                'student_number' => '1234562',
                'class_name' => 'XI PPLG',
            ],
            [
                'name' => 'Ahmad Jeremia Zadok',
                'email' => 'ahmad@achievo.test',
                'username' => 'ahmad',
                'student_number' => '1234563',
                'class_name' => 'XI PPLG',
            ],
            [
                'name' => 'Dhelta Nathan Fahlevi',
                'email' => 'dhelta@achievo.test',
                'username' => 'dhelta',
                'student_number' => '1234564',
                'class_name' => 'XI PPLG',
            ],
            [
                'name' => 'Jelita Olivia',
                'email' => 'jelita@achievo.test',
                'username' => 'jelita',
                'student_number' => '1234565',
                'class_name' => 'XI PPLG',
            ],
        ];

        $studentModels = [];
        foreach ($studentsData as $st) {
            $studentModels[] = User::updateOrCreate(
                ['email' => $st['email']],
                [
                    'name' => $st['name'],
                    'username' => $st['username'],
                    'password' => Hash::make('password'),
                    'student_number' => $st['student_number'],
                    'class_name' => $st['class_name'],
                    'role' => 'student',
                    'profile_visibility' => 'public',
                ]
            );
        }

        // 3. Kategori
        $categories = [
            ['name' => 'Akademik', 'slug' => 'akademik', 'description' => 'Olimpiade, karya tulis ilmiah, cerdas cermat'],
            ['name' => 'Teknologi', 'slug' => 'teknologi', 'description' => 'Coding, robotik, web development, animasi'],
            ['name' => 'Olahraga', 'slug' => 'olahraga', 'description' => 'Futsal, basket, bulutangkis, atletik'],
            ['name' => 'Seni & Kreativitas', 'slug' => 'seni', 'description' => 'Poster digital, menyanyi, melukis, tari'],
            ['name' => 'Organisasi', 'slug' => 'organisasi', 'description' => 'Kepemimpinan OSIS, MPK, Pramuka, PMR'],
            ['name' => 'Sosial & Lingkungan', 'slug' => 'sosial', 'description' => 'Relawan sosial, aksi lingkungan, duta kebersihan'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat['name']], $cat);
        }

        // 4. Aturan Poin
        $matrix = [
            'Internasional' => ['Juara 1' => 100, 'Juara 2' => 85, 'Juara 3' => 70, 'Peserta/Finalis' => 30],
            'Nasional'      => ['Juara 1' => 80,  'Juara 2' => 65, 'Juara 3' => 50, 'Peserta/Finalis' => 20],
            'Provinsi'      => ['Juara 1' => 60,  'Juara 2' => 45, 'Juara 3' => 35, 'Peserta/Finalis' => 15],
            'Kabupaten/Kota'=> ['Juara 1' => 40,  'Juara 2' => 30, 'Juara 3' => 20, 'Peserta/Finalis' => 10],
            'Sekolah'       => ['Juara 1' => 20,  'Juara 2' => 15, 'Juara 3' => 10, 'Peserta/Finalis' => 5],
        ];

        foreach ($matrix as $lvl => $results) {
            foreach ($results as $res => $pts) {
                PointRule::firstOrCreate(
                    ['level' => $lvl, 'result' => $res],
                    ['points' => $pts, 'is_active' => true]
                );
            }
        }

        // 5. Prestasi Sampel
        $ashley = $studentModels[0];
        $alicia = $studentModels[1];
        $ahmad = $studentModels[2];
        $dhelta = $studentModels[3];
        $jelita = $studentModels[4];

        // Prestasi Disetujui
        Achievement::firstOrCreate(
            ['title' => 'Juara 1 Lomba Web Development Nasional 2026', 'user_id' => $ashley->id],
            [
                'category' => 'Teknologi',
                'organizer' => 'Kementerian Kominfo',
                'level' => 'Nasional',
                'result' => 'Juara 1',
                'achievement_date' => '2026-04-10',
                'description' => 'Membuat platform web edukasi interaktif dan berhasil meraih juara pertama.',
                'visibility' => 'public',
                'verification_status' => 'approved',
                'points' => 80,
            ]
        );

        Achievement::firstOrCreate(
            ['title' => 'Juara 1 Hackathon Provinsi Jawa Barat 2026', 'user_id' => $ashley->id],
            [
                'category' => 'Teknologi',
                'organizer' => 'Dinas Pendidikan Jawa Barat',
                'level' => 'Provinsi',
                'result' => 'Juara 1',
                'achievement_date' => '2026-03-15',
                'description' => 'Membangun aplikasi cerdas untuk pemantauan prestasi siswa.',
                'visibility' => 'public',
                'verification_status' => 'approved',
                'points' => 60,
            ]
        );

        Achievement::firstOrCreate(
            ['title' => 'Juara 1 Olimpiade Matematika Nasional', 'user_id' => $alicia->id],
            [
                'category' => 'Akademik',
                'organizer' => 'Pusat Prestasi Nasional',
                'level' => 'Nasional',
                'result' => 'Juara 1',
                'achievement_date' => '2026-02-20',
                'description' => 'Medali Emas Olimpiade Sains Nasional bidang Matematika.',
                'visibility' => 'public',
                'verification_status' => 'approved',
                'points' => 80,
            ]
        );

        // Prestasi Pending untuk Verifikasi Admin
        Achievement::firstOrCreate(
            ['title' => 'Lomba Robotik Nasional 2026', 'user_id' => $ahmad->id],
            [
                'category' => 'Teknologi',
                'organizer' => 'Institut Teknologi Bandung',
                'level' => 'Nasional',
                'result' => 'Juara 2',
                'achievement_date' => '2026-04-25',
                'description' => 'Perlombaan rancang bangun robot otonom kategori maze solving.',
                'visibility' => 'public',
                'verification_status' => 'pending',
                'points' => 65,
            ]
        );

        Achievement::firstOrCreate(
            ['title' => 'Olimpiade Kimia Tingkat Provinsi', 'user_id' => $dhelta->id],
            [
                'category' => 'Akademik',
                'organizer' => 'Dinas Pendidikan',
                'level' => 'Provinsi',
                'result' => 'Juara 1',
                'achievement_date' => '2026-04-24',
                'description' => 'Olimpiade kimia tingkat SMA/SMK se-Jawa Barat.',
                'visibility' => 'public',
                'verification_status' => 'pending',
                'points' => 60,
            ]
        );

        Achievement::firstOrCreate(
            ['title' => 'Lomba Poster Digital Sekolah', 'user_id' => $jelita->id],
            [
                'category' => 'Seni & Kreativitas',
                'organizer' => 'OSIS SMK Metland Cibitung',
                'level' => 'Sekolah',
                'result' => 'Juara 1',
                'achievement_date' => '2026-04-24',
                'description' => 'Desain poster kampanye hemat energi dan ramah lingkungan.',
                'visibility' => 'public',
                'verification_status' => 'pending',
                'points' => 20,
            ]
        );

        // 6. Log Aktivitas
        ActivityLog::create([
            'user_id' => $admin->id,
            'action' => 'Menginisialisasi sistem dan verifikasi prestasi perdana',
        ]);
        ActivityLog::create([
            'user_id' => $admin->id,
            'action' => 'Menyetujui prestasi: Juara 1 Lomba Web Development Nasional 2026 milik Ashley Siburian',
        ]);
    }
}
