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
        Schema::table('schools', function (Blueprint $table) {
            $table->dropForeign(['school_category_id']);

            $table->foreign('school_category_id')
                ->references('id')
                ->on('school_categories')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign(['school_category_id']);

            $table->foreign('school_category_id')
                ->references('id')
                ->on('school_categories')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropForeign(['school_category_id']);

            $table->foreign('school_category_id')
                ->references('id')
                ->on('school_categories')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign(['school_category_id']);

            $table->foreign('school_category_id')
                ->references('id')
                ->on('school_categories')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }
};
