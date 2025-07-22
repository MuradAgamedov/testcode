<?php

namespace App\Filament\Resources\UserQuestionScoreResource\Pages;

use App\Filament\Resources\UserQuestionScoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserQuestionScores extends ListRecords
{
    protected static string $resource = UserQuestionScoreResource::class;

//    protected function getHeaderActions(): array
//    {
//        return [
//            Actions\CreateAction::make(),
//        ];
//    }
}
