<?php

namespace Abdiwaahid\Users\Filament\Resources\Activities\Schemas;

use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ActivityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        Section::make([
                            TextEntry::make('causer.name')->default('N/A')->label(__('users::messages.activity.causer')),
                            TextEntry::make('subject')->getStateUsing(function ($record) {
                                if (blank($record->subject_type)) {
                                    return $record->subject_type;
                                }
                                return str($record->subject_type)->afterLast('\\') . ' #' . $record->subject_id;
                            }),
                            TextEntry::make('description')->columnSpanFull(),
                        ])->columns(['md' => 2])->columnSpan(2),
                        Section::make([
                            TextEntry::make('event'),
                            TextEntry::make('created_at')->label(__('users::messages.activity.logged_at'))->dateTime(),
                        ])
                    ])->columnSpanFull(),
                Section::make()->schema(function ($record) {
                    $schema = [];
                    if ($record->properties && blank($record->properties['attributes'] ?? [])) {
                        $schema[] = KeyValueEntry::make('properties')->label(__('users::messages.activity.subject'));
                    }
                    if ($record->properties && filled($record->properties['old'] ?? [])) {
                        $schema[] = KeyValueEntry::make('properties.old')->label(__('users::messages.activity.old'));
                    }
                    if ($record->properties && filled($record->properties['attributes'] ?? [])) {
                        $schema[] = KeyValueEntry::make('properties.attributes')->label(__('users::messages.activity.attributes'));
                    }
                    return $schema;
                })->columns()->columnSpanFull(),
            ]);
    }
}
