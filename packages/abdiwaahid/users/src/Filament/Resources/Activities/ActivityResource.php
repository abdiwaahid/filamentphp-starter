<?php

namespace Abdiwaahid\Users\Filament\Resources\Activities;

use Abdiwaahid\Users\Filament\Resources\Activities\Pages\CreateActivity;
use Abdiwaahid\Users\Filament\Resources\Activities\Pages\ViewActivity;
use Abdiwaahid\Users\Filament\Resources\Activities\Pages\ListActivities;
use Abdiwaahid\Users\Filament\Resources\Activities\Schemas\ActivityForm;
use Abdiwaahid\Users\Filament\Resources\Activities\Schemas\ActivityInfolist;
use Abdiwaahid\Users\Filament\Resources\Activities\Tables\ActivitiesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getNavigationGroup(): string
    {
        return __('abdiwaahid-users::messages.activity.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('abdiwaahid-users::messages.activity.navigation.label');
    }

    public static function getNavigationIcon(): string
    {
        return __('abdiwaahid-users::messages.activity.navigation.icon');
    }

    public static function form(Schema $schema): Schema
    {
        return ActivityForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ActivityInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ActivitiesTable::configure($table);
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
            'index' => ListActivities::route('/'),
            'create' => CreateActivity::route('/create'),
            'view' => ViewActivity::route('/{record}'),
        ];
    }
}
