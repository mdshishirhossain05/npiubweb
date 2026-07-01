<?php

namespace App\Filament\Widgets;

use App\Models\AdmissionInquiry;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\News;
use App\Models\Notice;
use App\Models\Person;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Notices', Notice::count())
                ->description('Published announcements')
                ->color('primary'),
            Stat::make('News articles', News::count())
                ->color('info'),
            Stat::make('Upcoming events', Event::query()->where('starts_at', '>=', now())->count())
                ->color('success'),
            Stat::make('Faculty & staff', Person::count()),
            Stat::make('Unread messages', ContactMessage::query()->where('status', ContactMessage::STATUS_NEW)->count())
                ->description('Contact form submissions')
                ->color('warning'),
            Stat::make('New inquiries', AdmissionInquiry::query()->where('status', AdmissionInquiry::STATUS_NEW)->count())
                ->description('Admission inquiries')
                ->color('warning'),
        ];
    }
}
