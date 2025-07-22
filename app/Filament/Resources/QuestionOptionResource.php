<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionOptionResource\Pages;
use App\Models\Question;
use App\Models\QuestionOption;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuestionOptionResource extends Resource
{
    protected static ?string $model = QuestionOption::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Question Options';
    protected static ?string $modelLabel = 'Question Option';
    protected static ?string $pluralModelLabel = 'Question Options';
    protected static ?string $navigationGroup = 'Questions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('question_id')
                    ->label('Question')
                    ->relationship('question', 'title')
                    ->required(),

                Forms\Components\TextInput::make('label')
                    ->label('Label (A, B, C...)')
                    ->maxLength(1)
                    ->required(),

                Forms\Components\TextInput::make('option_text')
                    ->label('Option Text')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question.title')->label('Question')->searchable(),
                Tables\Columns\TextColumn::make('label')->label('Label'),
                Tables\Columns\TextColumn::make('option_text')->label('Option'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestionOptions::route('/'),
            'create' => Pages\CreateQuestionOption::route('/create'),
            'edit' => Pages\EditQuestionOption::route('/{record}/edit'),
        ];
    }
}
