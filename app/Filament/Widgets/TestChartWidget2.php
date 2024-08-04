<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\ChartWidget;

class TestChartWidget2 extends ChartWidget
{
    protected static ?string $heading = 'Project Status';

    protected static ?string $maxHeight = '255px';


    protected function getData(): array
    {
        return [
            'datasets' => [
                [
//                    'label' => 'Projects Completed This Month',
//                    'data' => [Project::where('company','=',auth()->user()->id)->where('status', '=', 'pending')->count(), Project::where('company','=',auth()->user()->id)->where('status', '=', 'ongoing')->count(), Project::where('company','=',auth()->user()->id)->where('status', '=', 'completed')->count()],
                    'data' => [30,20,70],
                    'backgroundColor' => ['#f6ad55', '#2b6cb0', '#48bb78'],
                ],
            ],
            'labels' => ['Pending', 'Ongoing', 'Completed'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
