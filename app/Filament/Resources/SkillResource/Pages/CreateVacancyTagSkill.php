<?php

namespace App\Filament\Resources\VacancyTagResource\Pages;

use App\Filament\Resources\SkillResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVacancyTagSkill extends CreateRecord
{
    protected static string $resource = SkillResource::class;
}
