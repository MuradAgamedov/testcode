<?php
namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Notifications\SendInitialPassword;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public string $generatedPassword;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->generatedPassword = Str::random(10);
        $data['password'] = Hash::make($this->generatedPassword);
        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->notify(new SendInitialPassword($this->generatedPassword));
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Ad')
                ->required(),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required(),

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
}
