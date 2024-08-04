<?php

namespace App\Filament\Resources\ProjectResource\Widgets;

use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pending Projects', Project::where('company', auth()->user()->id)->where('status', 'pending')->count())
                ->description('PENDING')
                ->descriptionIcon('heroicon-o-clock')
//                ->chart([400,200,100,50,30,10])
                ->color('danger'),
            Stat::make('Ongoing Projects', Project::where('company', auth()->user()->id)->where('status', 'ongoing')->count())
                ->description('ONGOING')
                ->descriptionIcon('heroicon-o-pencil')
//                ->chart([10,10,10,10,10,10])
                ->color('primary'),
            Stat::make('Completed Projects', Project::where('company', auth()->user()->id)->where('status', 'completed')->count())
                ->description('COMPLETED')
                ->descriptionIcon('heroicon-o-check-circle')
//                ->chart([20,30,50,100,200,400])
                ->color('success'),
        ];
    }
}
