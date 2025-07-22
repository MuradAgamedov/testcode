<?php

namespace App\Filament\Resources\UserQuestionScoreResource\Pages;

use App\Filament\Resources\UserQuestionScoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserQuestionScore extends EditRecord
{
    protected static string $resource = UserQuestionScoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
