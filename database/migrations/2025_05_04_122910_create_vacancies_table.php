<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacanciesTable extends Migration
{ 
    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();

            $table->string('title'); // Vacancy name
            $table->boolean('is_internship')->default(false); // This is an internship vacancy
            $table->date('deadline')->nullable(); // Deadline
            $table->string('vacancy_type')->nullable(); // Dropdown
            $table->text('description')->nullable(); // Description

            $table->string('technical_task_path')->nullable(); // File upload
            $table->string('technical_task_time')->nullable(); // Set time
            $table->json('skills')->nullable(); // Add skill

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacancies');
    }
}
