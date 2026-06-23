<?php

use App\Enums\QuizType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('quizzes', 'type')) {
            Schema::table('quizzes', function (Blueprint $table) {
                $table->string('type')->nullable()->after('school_category_id');
            });
        }

        if (Schema::hasTable('quiz_types') && Schema::hasColumn('quizzes', 'quiz_type_id')) {
            $quizTypes = DB::table('quiz_types')->pluck('name', 'id');

            DB::table('quizzes')
                ->select(['id', 'quiz_type_id'])
                ->orderBy('id')
                ->chunkById(100, function ($quizzes) use ($quizTypes) {
                    foreach ($quizzes as $quiz) {
                        $type = match ($quizTypes[$quiz->quiz_type_id] ?? null) {
                            'MC' => QuizType::MultipleChoice->value,
                            'TF' => QuizType::TrueFalse->value,
                            'ES' => QuizType::Essay->value,
                            default => null,
                        };

                        if ($type === null) {
                            continue;
                        }

                        DB::table('quizzes')
                            ->where('id', $quiz->id)
                            ->update(['type' => $type]);
                    }
                });
        }

        if (DB::table('quizzes')->whereNull('type')->exists()) {
            throw new RuntimeException('Unable to migrate quizzes.type because one or more quiz_type_id values could not be mapped.');
        }

        Schema::table('quizzes', function (Blueprint $table) {
            $table->string('type')->nullable(false)->change();
        });

        if (Schema::hasColumn('quizzes', 'quiz_type_id')) {
            Schema::table('quizzes', function (Blueprint $table) {
                $table->dropConstrainedForeignId('quiz_type_id');
            });
        }

        Schema::dropIfExists('quiz_types');
    }

    public function down(): void
    {
        if (! Schema::hasTable('quiz_types')) {
            Schema::create('quiz_types', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('description')->nullable();
                $table->timestamps();
            });

            DB::table('quiz_types')->insert([
                [
                    'id' => 1,
                    'name' => 'MC',
                    'description' => 'Pilihan Ganda',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 2,
                    'name' => 'TF',
                    'description' => 'Benar Salah',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 3,
                    'name' => 'ES',
                    'description' => 'Essay',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        if (! Schema::hasColumn('quizzes', 'quiz_type_id')) {
            Schema::table('quizzes', function (Blueprint $table) {
                $table->foreignId('quiz_type_id')->nullable()->after('school_category_id');
            });
        }

        DB::table('quizzes')
            ->where('type', QuizType::MultipleChoice->value)
            ->update(['quiz_type_id' => 1]);

        DB::table('quizzes')
            ->where('type', QuizType::TrueFalse->value)
            ->update(['quiz_type_id' => 2]);

        DB::table('quizzes')
            ->where('type', QuizType::Essay->value)
            ->update(['quiz_type_id' => 3]);

        Schema::table('quizzes', function (Blueprint $table) {
            $table->foreignId('quiz_type_id')->nullable(false)->change();
            $table->foreign('quiz_type_id')
                ->references('id')
                ->on('quiz_types')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->dropColumn('type');
        });
    }
};
