<?php

namespace Database\Seeders;

use App\Models\SchoolCategory;

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class SchoolCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'SMP',
                'description' => 'Sekolah Menengah Pertama',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'SMA',
                'description' => 'Sekolah Menengah Akhir',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        SchoolCategory::insert($categories);
    }
}
