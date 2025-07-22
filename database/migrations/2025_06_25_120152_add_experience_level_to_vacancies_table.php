<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->string('experience_level')->nullable()->after('title'); // haradan sonra istersen əlavə et
        });
    }

    public function down()
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropColumn('experience_level');
        });
    }

};
