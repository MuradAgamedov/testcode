<?php
namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Notifications\SendInitialPassword;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function saved(): void
    {
        parent::saved();

        $user = $this->record;

        // Təsadüfi şifrəni yaradın
        $newPassword = Str::random(12);  // 12 simvollu təsadüfi şifrə

        // Şifrəni yeniləyin
        $user->password = Hash::make($newPassword);
        $user->save();

        // Şifrəni istifadəçiyə bildiriş vasitəsilə göndərin
        $user->notify(new SendInitialPassword($newPassword));
    }
}
