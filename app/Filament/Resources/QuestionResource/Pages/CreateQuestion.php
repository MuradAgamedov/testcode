<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use App\Filament\Resources\QuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateQuestion extends CreateRecord
{
    protected static string $resource = QuestionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['correct_option_label']); // formda istifadə olunacaq, bazaya getməməlidir
        return $data;
    }

    protected function afterCreate(): void
    {
        $correctLabel = $this->data['correct_option_label'] ?? null;

        if ($correctLabel) {
            $correctOption = $this->record->options()
                ->where('label', $correctLabel)
                ->first();

            if ($correctOption) {
                $this->record->update([
                    'correct_option_id' => $correctOption->id,
                ]);
            }
        }
    }

}
