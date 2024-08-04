<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Unverified Employees', \App\Models\User::where('role', '=', 2)->where('selected_company', '=', auth()->user()->id)->where('approved', '=', 0)->count())
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger')
                ->description('Check It Out'),

            Stat::make('Completed Projects', Project::where('company', auth()->user()->id)->where('status', 'completed')->count())
                ->description('COMPLETED')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Ongoing Projects', Project::where('company', auth()->user()->id)->where('status', 'ongoing')->count())
                ->description('ONGOING')
                ->descriptionIcon('heroicon-o-pencil')
                ->color('primary'),
        ];
    }
}
