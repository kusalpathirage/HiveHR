<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Query\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            UserResource\Widgets\StatsOverview::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'Verified' => Tab::make()->modifyQueryUsing(function (\Illuminate\Database\Eloquent\Builder $query) {
                $query->where('approved', '=', 1);
            }),
            'Not Verified' => Tab::make()->modifyQueryUsing(function (\Illuminate\Database\Eloquent\Builder $query) {
                $query->where('approved', '=', 0);
            }),
        ];
    }
}
