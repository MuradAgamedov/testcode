<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run()
    {
        $skills = [
            // 💻 Texnologiya və proqramlaşdırma
            'PHP', 'Laravel', 'Symfony', 'Vue.js', 'React', 'Angular', 'Next.js', 'Nuxt.js',
            'HTML', 'CSS', 'JavaScript', 'TypeScript', 'Tailwind CSS', 'Bootstrap',
            'Python', 'Django', 'Flask', 'Java', 'Spring', 'C#', '.NET',
            'C++', 'Rust', 'Go', 'Ruby', 'Ruby on Rails',
            'MySQL', 'PostgreSQL', 'MongoDB', 'SQLite', 'Redis',
            'REST API', 'GraphQL', 'JSON', 'AJAX',
            'Docker', 'Kubernetes', 'Linux', 'Nginx', 'Apache',
            'Git', 'GitHub', 'GitLab', 'CI/CD', 'Unit Testing', 'TDD',
            'AWS', 'Azure', 'Google Cloud', 'Firebase',

            // 📈 Biznes və marketinq
            'CRM', 'ERP', 'SEO', 'SEM', 'SMM',
            'Google Ads', 'Facebook Ads', 'Mailchimp', 'LinkedIn Marketing',
            'Marketinq strategiyası', 'Brendinq', 'Dijital Marketinq', 'Rəqəmsal Analitika',

            // 💰 Maliyyə və mühasibatlıq
            '1C', 'Excel', 'Power BI', 'QuickBooks', 'Mühasibat uçotu',
            'Vergi hesabatları', 'Əmək haqqı hesablaması', 'Audit', 'Sığorta',

            // 👩‍🎨 Dizayn
            'UI/UX Dizayn', 'Figma', 'Adobe XD', 'Photoshop', 'Illustrator',
            'InDesign', 'Canva', '3D Dizayn', 'Motion Graphics',

            // 🧠 Soft Skills / Şəxsi bacarıqlar
            'Komanda işi', 'Tənqidi düşüncə', 'Vaxtın idarə edilməsi',
            'Problem həll etmə', 'Yenilikçi düşüncə', 'Təqdimat bacarığı', 'Liderlik',
            'Effektiv ünsiyyət', 'Müştəri yönümlülük',

            // 📚 Təhsil və pedaqoji bacarıqlar
            'Dərs planlaması', 'Online tədris', 'Müəllim resursları', 'Təlimin qiymətləndirilməsi',

            // ⚙️ Mühəndislik və texniki peşələr
            'AutoCAD', 'SketchUp', 'Revit', 'SolidWorks',
            'Elektrik mühəndisliyi', 'Tikinti nəzarəti', 'Mexanika',
            'CNC Operatorluğu', 'Texniki sənədləşmə',

            // 👨‍💼 İdarəetmə və ofis
            'Scrum', 'Agile', 'Jira', 'Trello', 'Asana',
            'Layihə idarəetməsi', 'HR', 'Təlim planlaması', 'Kadr uçotu',
            'Ofis proqramları', 'MS Word', 'MS Excel', 'Google Workspace'
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(['name' => $skill]);
        }
    }
}
