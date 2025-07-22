<?php


namespace App\Filament\Resources;

use App\Filament\Resources\ExperienceLevelResource\Pages;
use App\Models\ExperienceLevel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExperienceLevelResource extends Resource
{
    protected static ?string $model = ExperienceLevel::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';
    protected static ?string $navigationLabel = 'Təcrübə səviyyələri';
    protected static ?string $modelLabel = 'Təcrübə səviyyəsi';
    protected static ?string $pluralModelLabel = 'Təcrübə səviyyələri';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Səviyyə adı')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Səviyyə')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Yaradılma')->dateTime(),
            ])
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
            'index' => Pages\ListExperienceLevels::route('/'),
            'create' => Pages\CreateExperienceLevel::route('/create'),
            'edit' => Pages\EditExperienceLevel::route('/{record}/edit'),
        ];
    }
}
