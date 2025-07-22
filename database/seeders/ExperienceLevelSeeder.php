<?php

namespace Database\Seeders;

use App\Models\ExperienceLevel;
use Illuminate\Database\Seeder;

class ExperienceLevelSeeder extends Seeder
{
    public function run()
    {
        $levels = ['Junior', 'Middle', 'Senior'];

        foreach ($levels as $level) {
            ExperienceLevel::firstOrCreate(['name' => $level]);
        }
    }
}
