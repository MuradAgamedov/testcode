<?php


namespace Database\Seeders;

use App\Models\ApplicationStatus;
use Illuminate\Database\Seeder;

class ApplicationStatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = ['pending', 'approved', 'rejected'];

        foreach ($statuses as $status) {
            // Yalnız status mövcud deyilsə əlavə et
            ApplicationStatus::firstOrCreate(
                ['name' => $status],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}

