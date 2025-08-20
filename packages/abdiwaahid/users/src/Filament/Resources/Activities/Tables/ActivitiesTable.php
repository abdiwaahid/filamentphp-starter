<?php

namespace Abdiwaahid\Users\Filament\Resources\Activities\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table->modifyQueryUsing(fn($query) => $query->orderBy('created_at', 'desc'))
            ->columns([
                TextColumn::make('log_name')->label(__('abdiwaahid-users::messages.activity.log_name'))->badge()->sortable(),
                TextColumn::make('event')->formatStateUsing(fn($record)=> str($record->event)->title())->label(__('abdiwaahid-users::messages.activity.event'))->badge()->sortable(),
                TextColumn::make('description')->label(__('abdiwaahid-users::messages.activity.description'))->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('subject')->label(__('abdiwaahid-users::messages.activity.subject'))->getStateUsing(function ($record) {
                    if (blank($record->subject_type)) {
                        return $record->subject_type;
                    }
                    return str($record->subject_type)->afterLast('\\') . ' #' . $record->subject_id;
                })->sortable(),
                TextColumn::make('causer.name')->label(__('abdiwaahid-users::messages.activity.causer'))->sortable(),
                TextColumn::make('created_at')->label(__('abdiwaahid-users::messages.activity.logged_at'))->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
