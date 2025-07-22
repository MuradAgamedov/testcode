<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        $tables = [
            'users',
            'companies',
            'experience_levels',
            'interview_user',
            'news',
            'questions',
            'question_options',
            'roles',
            'skills',
            'task_answers',
            'topics',
            'user_education',
            'user_info',
            'user_question_scores',
            'user_socials',
            'user_work_experience',
            'vacancies',
            'vacancy_applications',
            'vacancy_application_interviews',
            'vacancy_application_tasks',
            'vacancy_technical_tasks',
            'wishlist_jobs',
        ];

        foreach ($tables as $tbl) {
            Schema::table($tbl, function (Blueprint $table) use ($tbl) {
                if (!Schema::hasColumn($tbl, 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }

    }

    public function down()
    {
        $tables = [
            'users',
            'companies',
            'experience_levels',
            'interview_user',
            'news',
            'questions',
            'question_options',
            'roles',
            'skills',
            'task_answers',
            'topics',
            'user_education',
            'user_info',
            'user_question_scores',
            'user_socials',
            'user_work_experience',
            'vacancies',
            'vacancy_applications',
            'vacancy_application_interviews',
            'vacancy_application_tasks',
            'vacancy_technical_tasks',
            'wishlist_jobs',
        ];

        foreach ($tables as $tbl) {
        Schema::table($tbl, function (Blueprint $table) use ($tbl) {
            if (!Schema::hasColumn($tbl, 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    }
};
