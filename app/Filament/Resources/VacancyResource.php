<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VacancyResource\Pages;
use App\Filament\Resources\VacancyResource\RelationManagers;
use App\Models\Vacancy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VacancyResource extends Resource
{
    protected static ?string $model = Vacancy::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Vacancies';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->required(),

            Forms\Components\Select::make('vacancy_type')
                ->options([
                    'Full-time' => 'Full-time',
                    'Part-time' => 'Part-time',
                    'Remote' => 'Remote',
                    'Internship' => 'Internship',
                ])
                ->required(),

            Forms\Components\Toggle::make('is_internship')
                ->label('Internship')
                ->default(false),

            Forms\Components\TextInput::make('technical_task_time')
                ->label('Technical Task Time')
                ->maxLength(100),

            Forms\Components\DatePicker::make('deadline')
                ->required(),

            Forms\Components\Select::make('company_id')
                ->relationship('company', 'name')
                ->required(),

            Forms\Components\Select::make('skill_ids')
                ->relationship('skills', 'name')
                ->multiple()
                ->preload(),

            Forms\Components\FileUpload::make('technical_task_file')
                ->directory('technical_tasks')
                ->visibility('public'),

            Forms\Components\Select::make('experience_level')
                ->options([
                    1 => '1 il',
                    2 => '2 il',
                    3 => '3 il',
                    4 => '4 il',
                    5 => '5+ il',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('vacancy_type')->sortable(),
                Tables\Columns\IconColumn::make('is_internship')->boolean(),
                Tables\Columns\TextColumn::make('experience_level'),
                Tables\Columns\TextColumn::make('deadline')->date(),
                Tables\Columns\TextColumn::make('company.name')->label('Company'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
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
            'index' => Pages\ListVacancies::route('/'),
            'create' => Pages\CreateVacancy::route('/create'),
            'edit' => Pages\EditVacancy::route('/{record}/edit'),
            'view' => Pages\ViewVacancy::route('/{record}'),
        ];
    }
}
