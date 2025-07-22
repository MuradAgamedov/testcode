<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('vacancies', function (Blueprint $table) {
        $table->renameColumn('experience_level', 'experience_year');
    });
}

public function down()
{
    Schema::table('vacancies', function (Blueprint $table) {
        $table->renameColumn('experience_year', 'experience_level');
    });
}

};
