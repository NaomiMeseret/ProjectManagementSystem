<?php

namespace App\Filament\Resources\Tasks;

use App\Enums\UserRole;
use App\Filament\Resources\Tasks\Pages\CreateTask;
use App\Filament\Resources\Tasks\Pages\EditTask;
use App\Filament\Resources\Tasks\Pages\ListTasks;
use App\Filament\Resources\Tasks\Schemas\TaskForm;
use App\Filament\Resources\Tasks\Tables\TasksTable;
use App\Models\Task;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
     
    protected static UnitEnum|string|null $navigationGroup = 'Task Management';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return TaskForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TasksTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->with(['project', 'assignee']);

        $user = auth()->user();

        if (! $user instanceof User) {
            return $query->whereKey([]);
        }

        if ($user->role === UserRole::ADMIN) {
            return $query;
        }

        if ($user->role === UserRole::MANAGER) {
            return $query->whereHas('project', function (Builder $projectQuery) use ($user): void {
                $projectQuery->where('created_by', $user->id);
            });
        }

        if ($user->role === UserRole::DEVELOPER) {
            return $query->where('assigned_to', $user->id);
        }

        return $query->whereKey([]);
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
            'index' => ListTasks::route('/'),
            'create' => CreateTask::route('/create'),
            'edit' => EditTask::route('/{record}/edit'),
        ];
    }
}
