<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountResource\Pages;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class AccountResource extends Resource
{
    public static $icon = 'heroicon-o-collection';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('id')->except(Pages\CreateAccount::class)->disabled(),
                Components\TextInput::make('company')->autofocus()->required(),
            ])
            ->columns(2);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('id')->sortable()->primary(),
                Columns\Text::make('company')->searchable()->sortable(),
                Columns\Text::make('created_at')->searchable()->sortable()->date(),
                Columns\Text::make('updated_at')->searchable()->sortable()->date(),
            ])
            ->filters([
                //
            ]);
    }

    public static function relations()
    {
        return [
            AccountResource\RelationManagers\GetUsersRelationManager::class,
        ];
    }

    public static function routes()
    {
        return [
            Pages\ListAccounts::routeTo('/', 'index'),
            Pages\CreateAccount::routeTo('/create', 'create'),
            Pages\EditAccount::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
