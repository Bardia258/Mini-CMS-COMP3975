<?php

namespace Database\Seeders;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'Title' => 'Student Services Fair Opens Spring Orientation Week',
                'Content' => '<p>Spring orientation week opened with a student services fair that introduced learners to academic advising, accessibility support, financial aid, and campus clubs.</p><p>The event focused on helping new students find the tools they need early in the term and feel more comfortable navigating daily campus life.</p>',
                'created_at' => Carbon::create(2026, 3, 25, 9, 0, 0),
            ],
            [
                'Title' => 'Library Adds Extended Evening Study Hours',
                'Content' => '<p>The campus library has extended weekday study hours to support students preparing for quizzes, labs, and project milestones.</p><p>Quiet study spaces, research assistance, and computer access remain available during the additional evening hours.</p>',
                'created_at' => Carbon::create(2026, 3, 26, 10, 30, 0),
            ],
            [
                'Title' => 'Design Lab Highlights Student Portfolio Work',
                'Content' => '<p>The design lab hosted a portfolio showcase featuring interface concepts, branding studies, and interactive prototypes built during the semester.</p><p>Students used the showcase to present their process work and collect feedback before final submissions.</p>',
                'created_at' => Carbon::create(2026, 3, 27, 13, 15, 0),
            ],
            [
                'Title' => 'Peer Tutoring Program Expands Weekend Support',
                'Content' => '<p>The peer tutoring program has added weekend sessions for students who need extra help with programming, writing, and technical coursework.</p><p>Appointments can be booked in advance, and drop-in support is available when tutors have open time slots.</p>',
                'created_at' => Carbon::create(2026, 3, 28, 11, 45, 0),
            ],
            [
                'Title' => 'Capstone Teams Prepare for End of Term Demo Day',
                'Content' => '<p>Capstone teams are entering the final preparation phase for demo day, where they will present working products, technical decisions, and lessons learned.</p><p>The event is intended to showcase progress in planning, implementation, testing, and communication.</p>',
                'created_at' => Carbon::create(2026, 3, 29, 14, 0, 0),
            ],
            [
                'Title' => 'Campus Sustainability Garden Starts New Growing Season',
                'Content' => '<p>Volunteers have started the new growing season in the campus sustainability garden with fresh planting beds, tool repairs, and a revised maintenance schedule.</p><p>The project combines hands-on collaboration with practical lessons about environmental responsibility and shared spaces.</p>',
                'created_at' => Carbon::create(2026, 3, 30, 8, 30, 0),
            ],
        ];


        foreach ($articles as $article) {
            Article::query()->create([
                'Title' => $article['Title'],
                'Content' => $article['Content'],
                'created_at' => $article['created_at'],
                'updated_at' => $article['created_at'],
            ]);
        }
    }
}
