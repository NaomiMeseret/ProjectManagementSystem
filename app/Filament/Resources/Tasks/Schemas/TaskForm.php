<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('priority')
                    ->options(TaskPriority::class)
                    ->default('medium')
                    ->required(),
                Select::make('status')
                    ->options(TaskStatus::class)
                    ->default('in_progress')
                    ->required(),
                Select::make('project_id')
                    ->relationship(
                        name: 'project',
                        titleAttribute: 'name',
                        modifyQueryUsing: function (Builder $query): void {
                            $user = auth()->user();

                            if (! $user instanceof User) {
                                $query->whereKey([]);

                                return;
                            }

                            if ($user->role === UserRole::MANAGER) {
                                $query->where('created_by', $user->id);
                            }
                        },
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('assigned_to')
                    ->relationship(
                        name: 'assignee',
                        titleAttribute: 'name',
                        modifyQueryUsing: function (Builder $query): void {
                            $query->where('role', UserRole::DEVELOPER->value);
                        },
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false),
            ]);
    }
}
