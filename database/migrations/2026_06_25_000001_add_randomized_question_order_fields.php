<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->boolean('randomize_questions')
                ->default(false)
                ->after('show_score');
        });

        Schema::table('student_quizzes', function (Blueprint $table) {
            $table->json('question_order')
                ->nullable()
                ->after('score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_quizzes', function (Blueprint $table) {
            $table->dropColumn('question_order');
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn('randomize_questions');
        });
    }
};
