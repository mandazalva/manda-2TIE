<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriesData = [
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Tutorial dan tips seputar pengembangan website modern dengan framework Laravel.',
            ],
            [
                'name' => 'Database & ORM',
                'slug' => 'database-orm',
                'description' => 'Panduan pengelolaan database MySQL, Eloquent ORM, dan teknik Query Builder.',
            ],
            [
                'name' => 'UI/UX Design',
                'slug' => 'ui-ux-design',
                'description' => 'Prinsip desain antarmuka, tata letak dashboard admin, dan pengalaman pengguna.',
            ],
            [
                'name' => 'Mobile Apps',
                'slug' => 'mobile-apps',
                'description' => 'Eksplorasi pengembangan aplikasi mobile Android, iOS, dan arsitektur REST API.',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = Category::firstOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }

        $postsData = [
            [
                'title' => 'Memahami Konsep Eloquent ORM di Laravel',
                'slug' => Str::slug('Memahami Konsep Eloquent ORM di Laravel'),
                'content' => 'Eloquent ORM adalah fitur bawaan Laravel yang memudahkan developer berinteraksi dengan tabel database menggunakan Model berorientasi objek. Dengan mendefinisikan relasi seperti belongsTo dan hasMany, pengambilan data antar tabel menjadi sangat sederhana dan ekspresif.',
                'category_id' => $categories['database-orm']->id,
                'is_published' => true,
            ],
            [
                'title' => 'Eksplorasi Query Builder dengan LeftJoin dan Where',
                'slug' => Str::slug('Eksplorasi Query Builder dengan LeftJoin dan Where'),
                'content' => 'Laravel Query Builder menyediakan antarmuka yang sangat fleksibel untuk menyusun query SQL yang kompleks. Dengan menggunakan DB::table(), pengembang dapat melakukan join/leftJoin antar tabel, agregasi data seperti COUNT(), serta menerapkan filter pencarian dengan nested where secara efisien.',
                'category_id' => $categories['database-orm']->id,
                'is_published' => true,
            ],
            [
                'title' => 'Membangun Web Dinamis Menggunakan Template Volt Bootstrap 5',
                'slug' => Str::slug('Membangun Web Dinamis Menggunakan Template Volt Bootstrap 5'),
                'content' => 'Integrasi template admin seperti Volt memudahkan pembuatan tampilan dashboard yang rapi dan profesional. Komponen tabel, form, breadcrumb, dan sidebar dapat disusun dengan Blade component secara modular.',
                'category_id' => $categories['web-development']->id,
                'is_published' => true,
            ],
            [
                'title' => 'Prinsip Desain Antarmuka Dashboard yang Nyaman untuk Pengguna',
                'slug' => Str::slug('Prinsip Desain Antarmuka Dashboard yang Nyaman untuk Pengguna'),
                'content' => 'Dashboard admin yang baik harus mengutamakan kemudahan navigasi dan hierarki informasi yang jelas. Pemilihan warna kontras yang pas pada badge status dan tombol aksi akan mempermudah admin dalam mengelola data.',
                'category_id' => $categories['ui-ux-design']->id,
                'is_published' => true,
            ],
            [
                'title' => 'Pengenalan Arsitektur API untuk Aplikasi Mobile Multiplatform',
                'slug' => Str::slug('Pengenalan Arsitektur API untuk Aplikasi Mobile Multiplatform'),
                'content' => 'Untuk menghubungkan aplikasi mobile seperti Flutter atau React Native dengan backend Laravel, penyediaan endpoint RESTful API dengan format JSON yang terstruktur dan aman sangatlah krusial.',
                'category_id' => $categories['mobile-apps']->id,
                'is_published' => true,
            ],
            [
                'title' => 'Optimasi Performa Query Database dengan Eager Loading',
                'slug' => Str::slug('Optimasi Performa Query Database dengan Eager Loading'),
                'content' => 'Masalah N+1 query seringkali terjadi saat melakukan looping relasi pada ORM. Dengan menggunakan eager loading Post::with("category"), Laravel hanya akan menjalankan query yang sangat minimal sehingga waktu pemuatan halaman menjadi jauh lebih cepat.',
                'category_id' => $categories['database-orm']->id,
                'is_published' => true,
            ],
        ];

        foreach ($postsData as $post) {
            Post::firstOrCreate(
                ['slug' => $post['slug']],
                $post
            );
        }
    }
}
