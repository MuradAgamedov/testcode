<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserQuestionScoreResource\Pages;
use App\Models\UserQuestionScore;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserQuestionScoreResource extends Resource
{
    protected static ?string $model = UserQuestionScore::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationLabel = 'User Scores';
    protected static ?string $pluralModelLabel = 'User Scores';
    protected static ?string $modelLabel = 'User Score';
    protected static ?string $navigationGroup = 'Progress';

    public static function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form->schema([]); // form istifadə olunmur
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),

                Tables\Columns\TextColumn::make('question.title')
                    ->label('Question')
                    ->searchable(),

                Tables\Columns\TextColumn::make('score')
                    ->label('Score')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Answered At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([]) // Edit yoxdur
            ->bulkActions([]); // Silmək də yoxdur
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserQuestionScores::route('/'),
            // YALNIZ baxış üçün, create/edit silindi
        ];
    }
}
