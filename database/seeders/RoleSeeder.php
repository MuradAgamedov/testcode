<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            // 💻 IT və Texnologiya
            'Frontend Developer',
            'Backend Developer',
            'Full Stack Developer',
            'Mobil Proqramçı (Flutter)',
            'UI/UX Dizayner',
            'DevOps Mühəndisi',
            'Data Analyst',
            'Data Scientist',
            'Sistem Administratoru',
            'Test Mühəndisi (QA)',
            'IT Dəstək (Helpdesk)',

            // 🧑‍🏫 Təhsil və Elm
            'Müəllim',
            'Təlimçi',
            'Tədqiqatçı',

            // 📈 Biznes və Marketinq
            'Marketinq Meneceri',
            'SMM Mütəxəssisi',
            'Satış Meneceri',
            'Layihə Meneceri',
            'Maliyyə Analitiki',
            'HR Mütəxəssisi',
            'Kadrlar üzrə Mütəxəssis',
            'Mühasib',

            // ⚙️ Mühəndislik və Texniki sahələr
            'Mexanik Mühəndis',
            'Tikinti Mühəndisi',
            'Elektrik Mühəndisi',
            'Texniki Nəzarətçi',

            // 🎨 Dizayn və Kreativ sahə
            'Qrafik Dizayner',
            'Video Redaktor',
            'Fotoqraf',

            // 🏢 İdarəetmə və Ofis
            'Katibə',
            'Ofis Meneceri',
            'Resepşn',
            'Direktor Köməkçisi',

            // 🏥 Tibb və Sosial sahə
            'Həkim',
            'Tibb Bacısı',
            'Psixoloq',
            'Sosial İşçi',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
