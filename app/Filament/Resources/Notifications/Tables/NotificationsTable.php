<?php

namespace App\Filament\Resources\Notifications\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NotificationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(function (string $state): string {
                        return class_basename($state);
                    })
                    ->searchable(),
                TextColumn::make('notifiable_id')
                    ->label('User ID')
                    ->sortable(),
                TextColumn::make('data.message')
                    ->label('Message')
                    ->default('No message')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('read_at')
                    ->label('Read At')
                    ->dateTime()
                    ->placeholder('Unread')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                //
            ]);
    }
}

