<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Post;
use Illuminate\Database\Seeder;

/**
 * DEMO content for events & news — replace with real school content later.
 */
class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title'       => 'KVS Science Fair 2026',
                'slug'        => 'science-fair-2026',
                'excerpt'     => 'Our young scientists present their experiments and inventions — from renewable energy models to robotics demos.',
                'body'        => "Every year, the KVS Science Fair transforms our campus into a hub of discovery. Students from Primary to Secondary present projects they have researched and built over the term — renewable energy models, robotics demos, chemistry experiments and more.\n\nParents are warmly invited to tour the exhibits, talk to the young scientists, and join the award ceremony at the end of the day.\n\nThis is a DEMO event description — replace with the real event details from the school's events calendar.",
                'image'       => '/images/placeholders/g-science-fair.svg',
                'location'    => 'KVS Main Hall',
                'starts_at'   => now()->addDays(12)->setTime(9, 0),
                'ends_at'     => now()->addDays(12)->setTime(14, 0),
                'is_featured' => true,
            ],
            [
                'title'       => 'Open Day — Meet KVS',
                'slug'        => 'open-day-2026',
                'excerpt'     => 'A full campus tour, meet our teachers, and get all your admissions questions answered in one visit.',
                'body'        => "Join us for our Open Day and experience life at Knowledge Valley first-hand. Tour the classrooms, labs, library and sports facilities, meet our teachers and leadership team, and get all your admissions questions answered.\n\nAdmissions assessments can be booked on the spot with a special Open Day discount on application fees.\n\nThis is a DEMO event description — replace with the real event details.",
                'image'       => '/images/placeholders/hero-campus.svg',
                'location'    => 'KVS Campus — Giza',
                'starts_at'   => now()->addDays(20)->setTime(10, 0),
                'ends_at'     => now()->addDays(20)->setTime(13, 0),
                'is_featured' => true,
            ],
            [
                'title'       => 'KVS Book Fair',
                'slug'        => 'book-fair-2026',
                'excerpt'     => 'A week-long celebration of reading with book stalls, author talks and storytelling corners for every stage.',
                'body'        => "The KVS Book Fair returns with book stalls in English, Arabic, German and French, author meet-and-greets, and storytelling corners for our youngest readers.\n\nAll proceeds support the school library fund.\n\nThis is a DEMO event description — replace with the real event details.",
                'image'       => '/images/placeholders/g-book-fair.svg',
                'location'    => 'KVS Library & Courtyard',
                'starts_at'   => now()->addDays(35)->setTime(8, 30),
                'ends_at'     => now()->addDays(39)->setTime(14, 0),
                'is_featured' => false,
            ],
            [
                'title'       => 'Chess Academy Tournament',
                'slug'        => 'chess-tournament-2026',
                'excerpt'     => 'Inter-house chess championship organized by the KVS Chess Academy — all stages welcome.',
                'body'        => "The KVS Chess Academy hosts its annual inter-house tournament. Students compete across age categories, with trophies for each stage and a grand champion title.\n\nThis is a DEMO event description — replace with the real event details.",
                'image'       => '/images/placeholders/g-chess.svg',
                'location'    => 'KVS Activities Hall',
                'starts_at'   => now()->addDays(48)->setTime(11, 0),
                'is_featured' => false,
            ],
            [
                'title'       => 'Graduation Ceremony 2025',
                'slug'        => 'graduation-2025',
                'excerpt'     => 'Celebrating our IGCSE graduates — a proud day for the whole KVS family.',
                'body'        => "We celebrated our IGCSE graduates in a memorable ceremony attended by families, teachers and the school board. Congratulations to the Class of 2025 — confident, responsible and ready for the future.\n\nThis is a DEMO event description — replace with the real event recap.",
                'image'       => '/images/placeholders/g-graduation.svg',
                'location'    => 'KVS Main Hall',
                'starts_at'   => now()->subDays(40)->setTime(17, 0),
                'is_featured' => false,
            ],
            [
                'title'       => 'International Peace Day',
                'slug'        => 'peace-day-2025',
                'excerpt'     => 'Students marked the UN International Day of Peace with art, performances and a whole-school assembly.',
                'body'        => "As part of the UN Global Schools Program, KVS marked the International Day of Peace with student performances, an art wall, and classroom activities linked to the Global Goals.\n\nThis is a DEMO event description — replace with the real event recap.",
                'image'       => '/images/placeholders/g-peace-day.svg',
                'location'    => 'KVS Campus',
                'starts_at'   => now()->subDays(90)->setTime(9, 0),
                'is_featured' => false,
            ],
        ];

        foreach ($events as $event) {
            Event::query()->updateOrCreate(['slug' => $event['slug']], $event);
        }

        $posts = [
            [
                'title'        => 'Admission Now Open for 2026/2027',
                'slug'         => 'admission-open-2026-2027',
                'excerpt'      => 'Applications are now open for all stages — Early Years, Primary and Secondary. Book your school tour today.',
                'body'         => "We are delighted to announce that admission for the 2026/2027 academic year is now open for all stages: Early Years (FS1–FS2), Primary (Years 1–6) and Secondary (IGCSE pathway).\n\nSeats are limited in some year groups — we encourage families to book a school tour and complete the assessment early.\n\nThis is a DEMO news article — replace with the real announcement.",
                'image'        => '/images/placeholders/admission-kid.svg',
                'published_at' => now()->subDays(5),
            ],
            [
                'title'        => 'Outstanding IGCSE Results for the Class of 2025',
                'slug'         => 'igcse-results-2025',
                'excerpt'      => 'Our students achieved exceptional results across Cambridge, Edexcel and Oxford AQA examinations.',
                'body'         => "We are proud to share that the Class of 2025 achieved outstanding IGCSE results across all three examination boards — Cambridge, Pearson Edexcel and Oxford International AQA.\n\nCongratulations to our students, teachers and parents on this collective achievement.\n\nThis is a DEMO news article — replace with the real results announcement and statistics.",
                'image'        => '/images/placeholders/hero-achievement.svg',
                'published_at' => now()->subDays(15),
            ],
            [
                'title'        => 'KVS Joins the UN Global Schools Program',
                'slug'         => 'un-global-schools',
                'excerpt'      => 'All 17 Sustainable Development Goals are now woven into everyday learning at KVS.',
                'body'         => "Knowledge Valley is officially part of the UN Global Schools Program. The 17 Sustainable Development Goals are integrated into our curriculum, giving students a global perspective from their first year.\n\nThis is a DEMO news article — replace with the real story.",
                'image'        => '/images/placeholders/g-peace-day.svg',
                'published_at' => now()->subDays(30),
            ],
            [
                'title'        => 'New German & French Certification Partnerships',
                'slug'         => 'language-partnerships',
                'excerpt'      => 'KVS students can now earn official language certificates with Goethe-Institut and Institut Français.',
                'body'         => "Through our partnerships with Goethe-Institut and Institut Français d'Égypte, KVS students study German and French with officially certified pathways — inside their own school.\n\nThis is a DEMO news article — replace with the real story.",
                'image'        => '/images/placeholders/c-classroom.svg',
                'published_at' => now()->subDays(45),
            ],
            [
                'title'        => 'Smart Cashless Campus: SPARE & Kashier Go Live',
                'slug'         => 'smart-campus-live',
                'excerpt'      => 'Parents can now manage fees, canteen, uniforms and transport digitally — from their phones.',
                'body'         => "Our smart campus systems are live. With SPARE and Kashier, parents handle fees, canteen balances, uniforms and transport digitally, with full transparency and peace of mind.\n\nThis is a DEMO news article — replace with the real story.",
                'image'        => '/images/placeholders/c-computer-lab.svg',
                'published_at' => now()->subDays(60),
            ],
            [
                'title'        => 'KVS Art Exhibition Highlights',
                'slug'         => 'art-exhibition-highlights',
                'excerpt'      => 'A look back at the creativity on display at this term\'s student art exhibition.',
                'body'         => "From watercolor landscapes to recycled-material sculpture, this term's art exhibition showed the depth of creative talent at KVS.\n\nThis is a DEMO news article — replace with the real recap and photos.",
                'image'        => '/images/placeholders/g-art.svg',
                'published_at' => now()->subDays(75),
            ],
        ];

        foreach ($posts as $post) {
            Post::query()->updateOrCreate(['slug' => $post['slug']], $post);
        }
    }
}
