<?php

namespace Tests\Unit;

use App\Models\Quiz;
use App\Models\QuizType;
use App\Models\School;
use App\Models\SchoolCategory;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SchoolCategoryDeletionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.connections.school_category_test', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);
        config()->set('database.default', 'school_category_test');

        DB::purge('school_category_test');
        DB::connection('school_category_test')->getPdo();

        $this->createSchema();
    }

    public function test_unused_category_can_be_deleted(): void
    {
        $category = SchoolCategory::create([
            'name' => 'Unused',
        ]);

        $this->assertTrue($category->delete());
        $this->assertDatabaseMissing('school_categories', [
            'id' => $category->id,
        ]);
    }

    public function test_category_with_school_cannot_be_deleted(): void
    {
        $category = $this->createCategory();

        School::create([
            'name' => 'School',
            'school_category_id' => $category->id,
        ]);

        $this->assertFalse($category->delete());
        $this->assertDatabaseHas('school_categories', [
            'id' => $category->id,
        ]);
    }

    public function test_category_with_quiz_cannot_be_deleted(): void
    {
        $category = $this->createCategory();
        $quizType = QuizType::create([
            'description' => 'Quiz Type',
        ]);

        Quiz::create([
            'name' => 'Quiz',
            'code' => 'QUIZ-001',
            'school_category_id' => $category->id,
            'quiz_type_id' => $quizType->id,
            'start_time' => '2026-05-23 08:00:00',
            'end_time' => '2026-05-23 09:00:00',
            'duration' => 60,
            'is_active' => true,
            'show_score' => false,
        ]);

        $this->assertFalse($category->delete());
        $this->assertDatabaseHas('school_categories', [
            'id' => $category->id,
        ]);
    }

    public function test_category_assigned_to_user_cannot_be_deleted(): void
    {
        $category = $this->createCategory();

        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'password',
            'school_category_id' => $category->id,
        ]);

        $this->assertFalse($category->delete());
        $this->assertDatabaseHas('school_categories', [
            'id' => $category->id,
        ]);
    }

    private function createCategory(): SchoolCategory
    {
        return SchoolCategory::create([
            'name' => 'SMP',
        ]);
    }

    private function createSchema(): void
    {
        Schema::create('school_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('school_category_id')->constrained('school_categories');
            $table->timestamps();
        });

        Schema::create('quiz_types', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->foreignId('school_category_id')->constrained('school_categories');
            $table->foreignId('quiz_type_id')->constrained('quiz_types');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('duration')->unsigned();
            $table->boolean('is_active')->nullable()->default(false);
            $table->boolean('show_score')->nullable()->default(false);
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('school_category_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }
}
