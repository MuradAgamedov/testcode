<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vacancy_technical_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vacancy_id')->constrained('vacancies')->onDelete('cascade');
            $table->string('file_path');
            $table->timestamps(); // includes created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacancy_technical_tasks');
    }
};
