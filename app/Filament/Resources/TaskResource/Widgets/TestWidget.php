<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pending Tasks', Task::where('company_id', auth()->user()->id)->where('status', 'pending')->count())
                ->description('PENDING')
                ->descriptionIcon('heroicon-o-clock')
//                ->chart([400,200,100,50,30,10])
                ->color('danger'),
            Stat::make('Ongoing Tasks', Task::where('company_id', auth()->user()->id)->where('status', 'ongoing')->count())
                ->description('ONGOING')
//                ->chart([10,10,10,10,10,10])
                ->descriptionIcon('heroicon-o-pencil')
                ->color('primary'),
            Stat::make('Completed Tasks', Task::where('company_id', auth()->user()->id)->where('status', 'completed')->count())
                ->description('COMPLETED')
                ->descriptionIcon('heroicon-o-check-circle')
//                ->chart([10,30,50,100,200,400])
                ->color('success'),
        ];
    }
}
