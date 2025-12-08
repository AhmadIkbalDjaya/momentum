<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'adminsmp',
            'username' => 'adminsmp',
            'email' => 'adminsmp@gmail.com',
            'password' => Hash::make('password'),
            'school_category_id' => '1',
        ]);
        User::create([
            'name' => 'adminsma',
            'username' => 'adminsma',
            'email' => 'adminsma@gmail.com',
            'password' => Hash::make('password'),
            'school_category_id' => '2',
        ]);
        $this->call(SchoolSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(QuizSeeder::class);
    }
}
