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
        $table->integer('experience_year')->nullable();
    });
}

public function down()
{
    Schema::table('vacancies', function (Blueprint $table) {
        $table->dropColumn('experience_year');
    });
}

};
