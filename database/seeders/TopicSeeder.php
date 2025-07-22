<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    public function run()
    {
        $topics = [
            // ✅ Proqramlaşdırma
            'Web Development',
            'Frontend Development',
            'Backend Development',
            'OOP (Object-Oriented Programming)',
            'Data Structures & Algorithms',
            'Database Management',
            'RESTful APIs',
            'Version Control (Git)',

            // ✅ Dillərə görə
            'PHP',
            'Laravel',
            'JavaScript',
            'Vue.js',
            'React',
            'Python',
            'Django',
            'HTML/CSS',

            // ✅ Texniki sahələr
            'Networking Basics',
            'Cybersecurity',
            'Linux & CLI',
            'DevOps Principles',
            'Cloud Computing',
            'Docker & Containers',

            // ✅ Digər mövzular
            'Project Management',
            'Scrum & Agile',
            'Problem Solving',
            'Team Communication',
            'Soft Skills',
        ];

        foreach ($topics as $name) {
            Topic::firstOrCreate(['name' => $name]);
        }
    }
}
