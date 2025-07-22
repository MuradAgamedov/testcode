<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    if (!Schema::hasTable('vacancy_applications')) {
        Schema::create('vacancy_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('vacancy_id');
            $table->foreignId('application_status_id');
            $table->timestamps();
        });
    }
}

  
};
