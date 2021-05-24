<?php

namespace App\Filament\Resources\AccountResource\RelationManagers;

use App\Filament\Resources\UserResource\Pages;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\RelationManager;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class GetUsersRelationManager extends RelationManager
{
    public static $primaryColumn = 'id';

    public static $relationship = 'users';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('id')->except(Pages\CreateUser::class)->disabled(),
                Components\TextInput::make('name')->autofocus()->required(),
                Components\TextInput::make('email')->email()->required(),
                Components\TextInput::make('role_id')->default(3)->only(Pages\CreateUser::class)->hidden(),
                Components\TextInput::make('password')->only(Pages\CreateUser::class)->password()->required(),
                Components\TextInput::make('password')->except(Pages\CreateUser::class)->label('New Password')->password(),
//                Components\Checkbox::make('reset')
//                    ->label('Reset Password?')
//                    ->stacked()
//                    ->dependable(),
//////                Components\Toggle::make('reset')
////                    ->label('Reset Password?')
////                    ->stacked()
////                    ->dependable(),
//                Components\Group::make([
//                    Components\TextInput::make('password')->password()->required(),
//                ])->when(fn ($record) => $record->reset == 'true'),
            ])
            ->columns(3);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('id')->sortable()->primary(),
                Columns\Text::make('name')->searchable()->sortable(),
                Columns\Text::make('email')->searchable()->sortable()->url(fn ($user) => "mailto:{$user->email}"),
                Columns\Text::make('created_at')->sortable()->date(),
                Columns\Text::make('updated_at')->sortable()->date(),
            ])
            ->filters([
                //
            ]);
    }
}
