<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run()
    {
        // İlk şirkət əlavə edilir
        Company::create([
            'name' => 'Example Corp',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // İkinci şirkət əlavə edilir
        Company::create([
            'name' => 'TechWorld Inc.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Üçüncü şirkət əlavə edilir
        Company::create([
            'name' => 'DataDrive LLC',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Dördüncü şirkət əlavə edilir
        Company::create([
            'name' => 'Digital Innovators',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Beşinci şirkət əlavə edilir
        Company::create([
            'name' => 'Creative Minds Studio',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Altıncı şirkət əlavə edilir
        Company::create([
            'name' => 'CloudTech Solutions',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Yedinci şirkət əlavə edilir
        Company::create([
            'name' => 'Innovative Ideas Ltd.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Səkkizinci şirkət əlavə edilir
        Company::create([
            'name' => 'FutureTech Ventures',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Doqquzuncu şirkət əlavə edilir
        Company::create([
            'name' => 'FinTech Innovations',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Onuncu şirkət əlavə edilir
        Company::create([
            'name' => 'Ecom Experts',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
