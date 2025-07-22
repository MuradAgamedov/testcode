<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Models\VacancyApplication;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static bool $canCreate = true;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Ad')
                ->required(),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),

            TextInput::make('password')
                ->label('Şifrə')
                ->password()
                ->required(fn(string $context) => $context === 'create')
                ->dehydrated(fn($state) => filled($state))
                ->maxLength(255),

            Select::make('user_type')
                ->label('İstifadəçi növü')
                ->default('hr')
                ->options([
                    'hr' => 'HR',
                    'worker' => 'Worker',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Ad')->searchable(),
            TextColumn::make('email')->label('Email')->searchable(),
            TextColumn::make('user_type')->label('Tip'),
            TextColumn::make('application_status')
                ->label('Application Status')
                ->getStateUsing(function (User $user) {
                    $application = VacancyApplication::with('applicationStatus')
                        ->where('user_id', $user->id)
                        ->latest()
                        ->first();

                    return $application?->applicationStatus?->name ?? null;
                })
                ->formatStateUsing(function (?string $state) {
                    return match ($state) {
                        'approved' => '✅ Accept',
                        'rejected' => '❌ Reject',
                        'pending' => '⏳ Pending',
                        default => '—',
                    };
                })
                ->html(),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
