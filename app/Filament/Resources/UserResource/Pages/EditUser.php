<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    public static $resource = UserResource::class;

        protected function beforeSave()
    {
        $newPassword = $this->record->getAttribute('password');
        $oldPassword = $this->record->getOriginal('password');

        if ($newPassword !== null) {
            $this->record->password = Hash::make($newPassword);
        } else {
            $this->record->password = Hash::make($oldPassword);
        }
    }
}
