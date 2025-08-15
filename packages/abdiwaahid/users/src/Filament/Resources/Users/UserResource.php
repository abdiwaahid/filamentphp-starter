<?php

namespace Abdiwaahid\Users\Filament\Resources\Users;

use Abdiwaahid\Users\Filament\Resources\Users\Pages\CreateUser;
use Abdiwaahid\Users\Filament\Resources\Users\Pages\EditUser;
use Abdiwaahid\Users\Filament\Resources\Users\Pages\ListUsers;
use Abdiwaahid\Users\Filament\Resources\Users\Schemas\UserForm;
use Abdiwaahid\Users\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'User';

    public static function getNavigationGroup(): string
    {
        return __('users::messages.user.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('users::messages.user.navigation.label');
    }

    public static function getNavigationIcon(): string
    {
        return __('users::messages.user.navigation.icon');
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            // 'create' => CreateUser::route('/create'),
            // 'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
