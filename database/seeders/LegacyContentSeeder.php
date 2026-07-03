<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

/**
 * Loads the real institutional content transcribed from the previous NPIUB
 * website (which had it hardcoded in Blade) into the new editable Pages.
 * Idempotent — safe to re-run; content is fully editable in the admin panel.
 */
class LegacyContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->upsert('vision-mission', 'Vision & Mission', $this->visionMission());
        $this->upsert('about', 'About NPIUB', $this->about());
        $this->upsert('board-of-trustees', 'Board of Trustees', $this->boardOfTrustees());
        $this->upsert('syndicate', 'Syndicate', $this->syndicate());
        $this->upsert('academic-council', 'Academic Council', $this->academicCouncil());
    }

    private function upsert(string $slug, string $title, string $content): void
    {
        Page::updateOrCreate(
            ['slug' => $slug],
            ['title' => $title, 'content' => $content, 'is_published' => true]
        );
    }

    private function visionMission(): string
    {
        return <<<'HTML'
        <p class="lead">Learn more about our commitment to excellence and the guiding principles that drive our institution.</p>
        <h2>Our Vision</h2>
        <p>To be a center of academic excellence and innovation in higher education—recognized nationally and globally for producing competent, ethical, and socially responsible graduates who will lead positive change in technology, industry, and society.</p>
        <h2>Our Mission</h2>
        <p>To foster an environment of excellence in teaching, research, and innovation that empowers students with knowledge, technical competence, and ethical values. NPI University of Bangladesh is committed to developing skilled graduates who can contribute effectively to national development and global advancement through critical thinking, creativity, and lifelong learning.</p>
        HTML;
    }

    private function about(): string
    {
        return <<<'HTML'
        <p>NPI University of Bangladesh (NPIUB) is a modern institution of higher education committed to quality teaching, research, and the development of skilled, ethical graduates. Founded in 2015, the university offers programs across engineering, business, and the arts, supported by experienced faculty and modern facilities.</p>
        <p>The university is governed by a distinguished Board of Trustees and guided by its Syndicate and Academic Council, ensuring academic integrity and institutional excellence.</p>
        HTML;
    }

    private function boardOfTrustees(): string
    {
        $trustees = [
            ['Chairman (BOT)', 'Engr. Md. Shamsur Rahman', '01711-349947', 'mdsrahman1953@gmail.com'],
            ['Vice-Chairman (BOT)', 'Mahadev Kundu', '01973-014547', 'mahadebkundu071@gmail.com'],
            ['Vice-Chairman (BOT)', 'Md. Zakir Hossain', '01715-651300', 'zhossain286@gmail.com'],
            ['Member Secretary (BOT)', 'Engr. Nirmal Chandra Sikder', '01711-240266', 'ncsikder@gmail.com'],
            ['Member (BOT)', 'Freedom Fighter Engr. Md. Idris Ali', '01711-855030', '56aliidris@gmail.com'],
            ['Member (BOT)', 'FMA Salam', '01704-444888', 'salamfma888@gmail.com'],
            ['Member (BOT)', 'Engr. Mohammod Faruque Hossain', '01735-782829', 'faruquecontro@gmail.com'],
            ['Member (BOT)', 'Engr. Md. Tariqul Islam', '01711-955385', 'milon102@gmail.com'],
            ['Member (BOT)', 'Engr. Md. Mahbubul Alam', '01712-136580', 'mahbubalam72004@gmail.com'],
            ['Member (BOT)', 'Engr. Md. Asif Idris', '01738-194690', 'mdasif172@gmail.com'],
            ['Member (BOT)', 'Engr. Argha Sikder Saurav', '01834-634610', 'ssargha@gmail.com'],
            ['Member (BOT)', 'Engr. Mohammad Arafat Idris', '01971-855030', 'arafat.idris.porosh@gmail.com'],
            ['Member (BOT)', 'A S M Shakib Rahman', '01886-969365', 'asmshakibrahman@gmail.com'],
            ['Member (BOT)', 'Engr. Md. Zahidul Islam', '01707-881780', 'zahidislam600@gmail.com'],
            ['Member (BOT)', 'Aurnob Kundu', '017950-41664', 'aurnob6577@gmail.com'],
            ['Member (BOT)', 'Afrin Haque Moni', '01704-444888', 'haqueafrin233@gmail.com'],
            ['Member (BOT)', 'Engr. Nargish Pervin', '01716-816240', 'rinamollick123@gmail.com'],
            ['Member (BOT)', 'S M Kamruzzaman', '017115-62078', 'tradeportbd@gmail.com'],
        ];

        $rows = '';
        foreach ($trustees as $i => [$role, $name, $phone, $email]) {
            $n = $i + 1;
            $rows .= "<tr><td>{$n}</td><td><strong>{$name}</strong></td><td>{$role}</td><td>{$phone}</td><td><a href=\"mailto:{$email}\">{$email}</a></td></tr>";
        }

        return '<p>The governance of NPI University of Bangladesh is entrusted to a distinguished panel of visionaries and thought leaders.</p>'
            .'<table><thead><tr><th>#</th><th>Name</th><th>Role</th><th>Phone</th><th>Email</th></tr></thead><tbody>'.$rows.'</tbody></table>';
    }

    private function syndicate(): string
    {
        $members = [
            ['সভাপতি', 'প্রফেসর ড. মোঃ ফরহাদ হোসেন', 'উপাচার্য, এনপিআইইউবি'],
            ['সদস্য', 'অধ্যাপক ড. মীর মাহফুজুল হক', 'ট্রেজারার, এনপিআইইউবি'],
            ['সদস্য', 'মোঃ মোশাররফ হোসেন', 'পরীক্ষা নিয়ন্ত্রক, উপাচার্য কর্তৃক মনোনীত, এনপিআইইউবি'],
            ['সদস্য', 'বীর মুক্তিযোদ্ধা প্রফেসর ড. ফরমুজুল হক', 'ডীন, ইঞ্জিনিয়ারিং অনুষদ, উপাচার্য কর্তৃক মনোনীত, এনপিআইইউবি'],
            ['সদস্য', 'সরকার কর্তৃক মনোনীত একজন সদস্য', 'সরকার মনোনীত সদস্য'],
            ['সদস্য', 'বীর মুক্তিযোদ্ধা মোঃ ইদ্রিস আলী', 'বোর্ড অব ট্রাস্টিজ কর্তৃক মনোনীত সদস্য, এনপিআইইউবি'],
            ['সদস্য', 'এফ. এম. এ. সালাম', 'বোর্ড অব ট্রাস্টিজ কর্তৃক মনোনীত সদস্য, এনপিআইইউবি'],
            ['সদস্য', 'ইঞ্জিঃ নির্মল চন্দ্র সিকদার', 'বোর্ড অব ট্রাস্টিজ কর্তৃক মনোনীত সদস্য, এনপিআইইউবি'],
            ['সদস্য', 'প্রফেসর ড. মোহাম্মদ আলমুজাদ্দিদ আলফেসানি', 'ইউজিসি কর্তৃক মনোনীত সদস্য'],
            ['সদস্য সচিব', 'মুহাম্মাদ আবদুল গফুর', 'রেজিস্ট্রার, এনপিআইইউবি'],
        ];

        return $this->bengaliMemberTable(
            'এনপিআইইউবির সিন্ডিকেট হলো বিশ্ববিদ্যালয়ের প্রশাসনিক ও নীতিনির্ধারণী সর্বোচ্চ নির্বাহী কমিটি।',
            'সিন্ডিকেটের সম্মানিত সদস্যবৃন্দ',
            $members
        );
    }

    private function academicCouncil(): string
    {
        $members = [
            ['সভাপতি', 'প্রফেসর ড. মোঃ ফরহাদ হোসেন', 'উপাচার্য, এনপিআইইউবি'],
            ['সদস্য', 'বীর মুক্তিযোদ্ধা প্রফেসর ড. ফরমুজুল হক', 'ডীন, ইঞ্জিনিয়ারিং অনুষদ, এনপিআইইউবি'],
            ['সদস্য', 'ড. মোঃ রমজান আলী', 'সাবেক ডীন, ঢাকা বিশ্ববিদ্যালয়; বোর্ড অব ট্রাস্টিজ কর্তৃক মনোনীত, এনপিআইইউবি'],
            ['সদস্য', 'ইঞ্জিঃ মোঃ মাহবুবুর রহমান', 'বিভাগীয় প্রধান, কম্পিউটার সায়েন্স এন্ড ইঞ্জিনিয়ারিং বিভাগ, এনপিআইইউবি'],
            ['সদস্য', 'মোঃ তৌহিদুল ইসলাম', 'বিভাগীয় প্রধান, ব্যবসায় প্রশাসন বিভাগ, এনপিআইইউবি'],
            ['সদস্য', 'মোঃ ফাহাদ হোসেন', 'বিভাগীয় প্রধান, ইংরেজি বিভাগ, এনপিআইইউবি'],
            ['সদস্য', 'ইঞ্জিঃ খালেদ সাইফুল্লাহ', 'বিভাগীয় প্রধান, ইইই বিভাগ, এনপিআইইউবি'],
            ['সদস্য', 'প্রফেসর মোঃ শহীদুজ্জামান', 'অধ্যক্ষ, সরকারি দেবেন্দ্র কলেজ, মানিকগঞ্জ; বোর্ড অব ট্রাস্টিজ কর্তৃক মনোনীত, এনপিআইইউবি'],
            ['সদস্য', 'মোঃ ইউনুস আল মামুন', 'অধ্যক্ষ, তেতুলঝোরা কলেজ, সাভার, ঢাকা; বোর্ড অব ট্রাস্টিজ কর্তৃক মনোনীত, এনপিআইইউবি'],
            ['সদস্য', 'মোঃ মোশাররফ হোসেন', 'পরীক্ষা নিয়ন্ত্রক, সিন্ডিকেট কর্তৃক মনোনীত, এনপিআইইউবি'],
            ['সদস্য', 'মোঃ নূর উদ্দিন', 'অধ্যক্ষ, সিঙ্গাইর সরকারি কলেজ, সিঙ্গাইর, মানিকগঞ্জ'],
            ['সদস্য সচিব', 'মুহাম্মাদ আবদুল গফুর', 'রেজিস্ট্রার, এনপিআইইউবি'],
        ];

        return $this->bengaliMemberTable(
            'এনপিআইইউবির একাডেমিক কাউন্সিল হলো বিশ্ববিদ্যালয়ের শিক্ষা, পাঠ্যক্রম, পরীক্ষা এবং একাডেমিক নীতিমালা প্রণয়ন ও অনুমোদনের সর্বোচ্চ একাডেমিক কর্তৃপক্ষ।',
            'সম্মানিত সদস্যবৃন্দ',
            $members
        );
    }

    /**
     * @param  array<int, array{0:string,1:string,2:string}>  $members
     */
    private function bengaliMemberTable(string $intro, string $heading, array $members): string
    {
        $rows = '';
        foreach ($members as $i => [$role, $name, $detail]) {
            $n = $i + 1;
            $rows .= "<tr><td>{$n}</td><td>{$role}</td><td><strong>{$name}</strong></td><td>{$detail}</td></tr>";
        }

        return '<div class="font-bengali">'
            ."<p class=\"lead\">{$intro}</p>"
            ."<h2>{$heading}</h2>"
            .'<table><thead><tr><th>ক্রম</th><th>ভূমিকা</th><th>নাম</th><th>পদবি / পরিচিতি</th></tr></thead><tbody>'.$rows.'</tbody></table>'
            .'</div>';
    }
}
