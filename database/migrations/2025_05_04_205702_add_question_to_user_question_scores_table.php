<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user_question_scores', function (Blueprint $table) {
            $table->text('question_option')->nullable()->after('question_id'); // və ya uyğun sahədən sonra
        });
    }

    public function down(): void
    {
        Schema::table('user_question_scores', function (Blueprint $table) {
            $table->dropColumn('question_option');
        });
    }
};
