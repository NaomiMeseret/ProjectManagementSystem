<?php

namespace App\Filament\Resources\Tasks\Tables;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Select as SelectField;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('priority')
                    ->badge()
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('project.name')
                    ->searchable(),
                TextColumn::make('assignee.name')
                    ->label('Assigned To')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(self::enumOptions(TaskStatus::cases())),
                SelectFilter::make('priority')
                    ->label('Priority')
                    ->options(self::enumOptions(TaskPriority::cases())),
                SelectFilter::make('assigned_to')
                    ->label('Assigned User')
                    ->relationship('assignee', 'name')
                    ->searchable()
                    ->preload(),
                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('change_status')
                    ->label('Change Status')
                    ->color('warning')
                    ->form([
                        SelectField::make('status')
                            ->options(self::enumOptions(TaskStatus::cases()))
                            ->required(),
                    ])
                    ->fillForm(function (Task $record): array {
                        return [
                            'status' => $record->status->value,
                        ];
                    })
                    ->visible(function (Task $record): bool {
                        return self::canChangeStatus($record);
                    })
                    ->action(function (Task $record, array $data): void {
                        abort_unless(self::canChangeStatus($record), 403);

                        app(TaskService::class)->changeTaskStatus(
                            $record,
                            TaskStatus::from($data['status']),
                        );
                    })
                    ->successNotificationTitle('Task status updated successfully.'),
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    private static function enumOptions(array $cases): array
    {
        $options = [];

        foreach ($cases as $case) {
            $options[$case->value] = str($case->value)
                ->replace('_', ' ')
                ->title()
                ->toString();
        }

        return $options;
    }

    private static function canChangeStatus(Task $task): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->can('changeStatus', $task);
    }
}
