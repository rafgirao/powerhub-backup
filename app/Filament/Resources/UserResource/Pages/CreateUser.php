<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    public static $resource = UserResource::class;

    protected function beforeCreate()
    {
        $this->record['password'] = Hash::make($this->record['password']);
    }
}
