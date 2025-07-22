<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperienceLevelsTable extends Migration
{
    public function up()
    {
        Schema::create('experience_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g. Junior, Mid, Senior
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('experience_levels');
    }
}
