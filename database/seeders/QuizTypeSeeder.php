<?php

namespace Database\Seeders;

use App\Models\QuizType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class QuizTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'MC',
                'description' => 'Pilihan Ganda',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'TF',
                'description' => 'Benar Salah',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ES',
                'description' => 'Essay',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        QuizType::insert($types);
    }
}
