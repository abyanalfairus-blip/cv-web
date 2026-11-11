<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Isi database aplikasi: php artisan db:seed
     */
    public function run(): void
    {
        $this->call([
            CvSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
