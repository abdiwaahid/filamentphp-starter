<?php

namespace Abdiwaahid\Users\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                TextInput::make('email')->label('Email address')->email()->required(),
                Select::make('roles')->multiple()->relationship('roles', 'name')->preload()->required()->columnSpanFull(),
                TextInput::make('password')->password()->revealable()->required(fn($record) => !$record),
                TextInput::make('confirm_password')->password()->revealable()->required(fn($record) => !$record)->same('password'),

            ]);
    }
}
