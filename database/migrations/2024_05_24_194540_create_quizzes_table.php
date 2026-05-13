<?php

use App\Models\QuizType;
use App\Models\SchoolCategory;
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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->foreignIdFor(SchoolCategory::class)
                ->constrained()
                ->references('id')
                ->on('school_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignIdFor(QuizType::class)
                ->constrained()
                ->references('id')
                ->on('quiz_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('duration')->unsigned();
            $table->boolean('is_active')->nullable()->default(false);
            $table->boolean('show_score')->nullable()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
