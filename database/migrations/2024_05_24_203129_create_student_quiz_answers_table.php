<?php

use App\Models\Option;
use App\Models\Question;
use App\Models\StudentQuiz;
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
        Schema::create('student_quiz_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(StudentQuiz::class)
                ->constrained()
                ->references('id')
                ->on('student_quizzes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignIdFor(Question::class)
                ->constrained()
                ->references('id')
                ->on('questions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignIdFor(Option::class)
                ->constrained()
                ->references('id')
                ->on('options')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('is_correct')->nullable()->default(false);
            $table->timestamps();
            $table->unique(['student_quiz_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_quiz_answers');
    }
};
