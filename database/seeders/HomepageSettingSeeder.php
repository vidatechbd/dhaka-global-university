<?php

namespace Database\Seeders;

use App\Models\HomepageSetting;
use Illuminate\Database\Seeder;

class HomepageSettingSeeder extends Seeder
{
    public function run(): void
    {
        HomepageSetting::truncate(); // Truncate to avoid duplicates when running seeder again
        HomepageSetting::create([
            'show_top_bar' => true,
            'top_bar_email' => 'registrar@feniuniversity.ac.bd',
            'top_bar_phone' => '02334474194',
            'top_bar_links' => [
                ['title' => 'Career', 'url' => '/career'],
                ['title' => 'Alumni', 'url' => '/alumni'],
            ],
            'show_hero' => true,
            'hero_slides' => [
                [
                    'image' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1920&q=80',
                    'tag' => 'Fall 2026 Admissions Open',
                    'title' => 'Empowering Minds, <br> Building the Future.',
                    'description' => 'Welcome to Dhaka Global University. We are committed to academic excellence, ethical standards, and producing leaders for tomorrow\'s challenges.',
                    'btn_text_1' => 'Explore Programs',
                    'btn_url_1' => '#',
                    'btn_text_2' => 'Virtual Tour',
                    'btn_url_2' => '#',
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1920&q=80',
                    'tag' => 'Research & Innovation',
                    'title' => 'Inspiring Discovery, <br> Creating Knowledge.',
                    'description' => 'Our campus offers state of the art labs, resourceful libraries and research facilities for academic growth.',
                    'btn_text_1' => 'Explore Research',
                    'btn_url_1' => '#',
                    'btn_text_2' => 'Publications',
                    'btn_url_2' => '#',
                ],
            ],

            'show_about' => true,
            'about_tag' => 'About Dhaka Global University',
            'about_title' => 'A Center for Quality Education & Ethical Standards.',
            'about_description' => '<p><strong>Dhaka Global University (DGU)</strong> started its academic activities with a vision to promote ethical standards and flourish as a center of excellence in higher education in the country.</p><p>It provides tertiary level education at an affordable cost without compromising quality. Our dynamic faculty and modern facilities ensure students are prepared for global challenges.</p>',
            'about_years' => '11+',
            'about_image' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=800&q=80',
            'about_url' => '#',

            'show_leadership' => true,
            'leadership_title' => 'Leadership & Authorities',
            'leadership_description' => 'Guided by visionary leaders dedicated to academic brilliance and institutional integrity.',
            'leadership_members' => [
                [
                    'name' => 'Brig. Gen. (Rtd.) Nasir Uddin',
                    'designation' => 'Chairman, BOT',
                    'image' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=256&q=80',
                    'message_url' => '#',
                ],
                [
                    'name' => 'Prof. Dr. Md. Fazli Ilahi',
                    'designation' => 'Vice Chancellor',
                    'image' => 'https://images.unsplash.com/photo-1556157382-97eda2d62296?auto=format&fit=crop&w=256&q=80',
                    'message_url' => '#',
                ],
                [
                    'name' => 'Prof. Dr. Tayabul Haq',
                    'designation' => 'Treasurer',
                    'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=256&q=80',
                    'message_url' => '#',
                ],
                [
                    'name' => 'A S M Abul Khair',
                    'designation' => 'Registrar',
                    'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=256&q=80',
                    'message_url' => '#',
                ],
            ],

            'show_faculties' => true,
            'faculties_title' => 'Academic Faculties',
            'faculties_btn_text' => 'View All Programs',
            'faculties_btn_url' => '#',
            'faculties' => [
                [
                    'name' => 'Arts, Social Science & Law',
                    'image' => 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&w=800&q=80',
                    'explore_url' => '#',
                    'depts' => ['Dept. of English', 'Dept. of Law'],
                ],
                [
                    'name' => 'Business Administration',
                    'image' => 'https://images.unsplash.com/photo-1434626881859-194d67b2b86f?auto=format&fit=crop&w=800&q=80',
                    'explore_url' => '#',
                    'depts' => ['BBA Program', 'MBA (Regular & Executive)'],
                ],
                [
                    'name' => 'Science & Engineering',
                    'image' => 'https://images.unsplash.com/photo-1517077304055-6e89abbf09b0?auto=format&fit=crop&w=800&q=80',
                    'explore_url' => '#',
                    'depts' => ['Computer Science (CSE)', 'Civil Engineering (CE)', 'EEE'],
                ],
            ],

            'show_news_notice' => true,
        ]);
    }
}
