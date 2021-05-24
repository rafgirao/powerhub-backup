<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Resources\Pages\ListRecords;
use Grosv\LaravelPasswordlessLogin\PasswordlessLogin;

class ListUsers extends ListRecords
{
    public static $resource = UserResource::class;
}
