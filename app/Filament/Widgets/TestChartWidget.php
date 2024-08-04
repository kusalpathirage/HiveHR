<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Employees';

    protected function getData(): array
    {
        return [
            // generate a demo chart
            'datasets' => [
                [
                    'label' => 'Employees Joined This Month',
                    'data' => [10, 10, 15, 20, 21, 32, 45, 74, 75, 76, 77, 89],
                ],
            ],
            'labels' => ['1', '2', '3', '4', '5', '6', '7', '10', '11', '12', '13', '14'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
