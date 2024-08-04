<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Project Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
//                            ->live()
//                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
//                            $set('slug', Str::slug($state));
//                        })
                            ->label('Title')->required()->columnSpanFull(),
//                        Forms\Components\TextInput::make('slug')->label('URL')->unique()->minLength(3)->maxLength(150)->required(),
                        Forms\Components\FileUpload::make('thumbnail')->label('Thumbnail')
                            ->required()
                            ->image()->columnSpanFull()->directory('projects/thumbnails'),
                        Forms\Components\RichEditor::make('description')->label('Description')->required()->fileAttachmentsDirectory('projects/images')->columnSpanFull(),
                        ToggleButtons::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'ongoing' => 'Ongoing',
                                'completed' => 'Completed'
                            ])
                            ->icons([
                                'pending' => 'heroicon-o-clock',
                                'ongoing' => 'heroicon-o-pencil',
                                'completed' => 'heroicon-o-check-circle',
                            ])
                            ->colors([
                                'pending' => 'danger',
                                'ongoing' => 'warning',
                                'completed' => 'success',
                            ])
                            ->grouped()
                            ->inline()
                            ->required(),
//                        Forms\Components\Toggle::make('visibility')->label('Visibility')->required()->inline(false),
//                        ToggleButtons::make('visibility')
//                            ->label('Visibility')
//                            ->boolean()
//                            ->grouped()
//                            ->required()
                    ])->columns(2),
                Forms\Components\Section::make('Team Details')
                    ->schema([
//                        Forms\Components\Select::make('project_leader')
//
//                            ->required()
//                            ->searchable(),

                        Forms\Components\Select::make('project_leader')
                            ->relationship('projectLeader', 'name')
                            ->label('Project Manager')
                            ->required()
                            ->searchable()
                            ->options(User::where('role', '=', 2)->where('career_role', '=', 1)->where('selected_company', '=', auth()->user()->id)->get()->pluck('name', 'id')->toArray()),


//                        Forms\Components\TextInput::make('team_members')->label('Team Members')->required(),
                        Forms\Components\Select::make('team_members')
                            ->label('Team Members')
                            ->relationship('teamMembers', 'name')
                            ->required()
                            ->searchable()
                            ->multiple()
                            ->options(User::where('role', '=', 2)->where('career_role', '!=', 1)->where('selected_company', '=', auth()->user()->id)->get()->pluck('name', 'id')->toArray()),
//                            ->options(User::where('role', '=', 2)->where('career_role', '=', 1)->get()->pluck('name', 'id')->toArray()),
                    ])->columns(2),
            ]);
        // create a section

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')->label('Image'),
                Tables\Columns\TextColumn::make('title')->label('Title')->searchable()->sortable()->limit(50),
//                Tables\Columns\TextColumn::make('description')->label('Description')->searchable()->sortable()->limit(50),
//                Tables\Columns\TextColumn::make('status')
//                    ->badge()
//                    ->color(fn(string $state): string => match ($state) {
//                        'pending' => 'danger',
//                        'ongoing' => 'warning',
//                        'completed' => 'success',
//                    }),

                Tables\Columns\TextColumn::make('projectLeader.name')->label('Project Manager')->searchable()->sortable()->limit(50),
                Tables\Columns\TextColumn::make('teamMembers.name')->badge()->label('Team Members')->searchable()->sortable()->limit(50),
                IconColumn::make('status')->sortable()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'danger',
                        'ongoing' => 'warning',
                        'completed' => 'success',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'ongoing' => 'heroicon-o-pencil',
                        'completed' => 'heroicon-o-check-circle',
                    }),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('company', auth()->user()->id)
            ->orWhere('company', auth()->user()->selected_company);
    }
}
