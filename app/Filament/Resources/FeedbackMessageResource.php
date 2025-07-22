<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedbackMessageResource\Pages;
use App\Models\FeedbackMessage;
use Filament\Forms;
use App\Filament\Resources\FeedbackMessageResource\RelationManagers;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeedbackMessageResource extends Resource
{
    protected static ?string $model = FeedbackMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationGroup = 'Messages';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            \Filament\Forms\Components\TextInput::make('name')->disabled(),
            \Filament\Forms\Components\TextInput::make('email')->disabled(),
            \Filament\Forms\Components\TextInput::make('role')->disabled(),
            \Filament\Forms\Components\Textarea::make('message')->disabled(),
            \Filament\Forms\Components\DateTimePicker::make('created_at')->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('role'),
                Tables\Columns\TextColumn::make('message')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->since(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListFeedbackMessages::route('/'),

            'view' => Pages\ViewFeedbackMessage::route('/{record}'),

            'create' => Pages\CreateFeedbackMessage::route('/create'),
            'edit' => Pages\EditFeedbackMessage::route('/{record}/edit'),

        ];
    }
}
