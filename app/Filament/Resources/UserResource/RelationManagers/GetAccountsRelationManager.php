<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\RelationManager;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class GetAccountsRelationManager extends RelationManager
{
    public static $primaryColumn = 'id';

    public static $relationship = 'accounts';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('id')->disabled(),
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
                Columns\Text::make('created_at')->sortable()->date(),
                Columns\Text::make('updated_at')->sortable()->date(),
            ])
            ->filters([
                //
            ]);
    }
}
