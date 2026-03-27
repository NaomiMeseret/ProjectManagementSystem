<?php

namespace App\Filament\Resources\Comments;

use App\Enums\UserRole;
use App\Filament\Resources\Comments\Pages\CreateComment;
use App\Filament\Resources\Comments\Pages\EditComment;
use App\Filament\Resources\Comments\Pages\ListComments;
use App\Filament\Resources\Comments\Schemas\CommentForm;
use App\Filament\Resources\Comments\Tables\CommentsTable;
use App\Models\Comment;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static UnitEnum|string|null $navigationGroup = 'Comment Management';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleOvalLeftEllipsis;

    protected static ?string $recordTitleAttribute = 'comment';

    public static function form(Schema $schema): Schema
    {
        return CommentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommentsTable::configure($table);
    }

    public static function canViewAny(): bool
    {
        return auth()->check();
    }

    public static function canCreate(): bool
    {
        return auth()->check();
    }

    public static function canEdit(Model $record): bool
    {
        $user = auth()->user();

        return $user instanceof User
            && $record instanceof Comment
            && static::userCanManageRecord($user, $record);
    }

    public static function canDelete(Model $record): bool
    {
        $user = auth()->user();

        return $user instanceof User
            && $record instanceof Comment
            && static::userCanManageRecord($user, $record);
    }

    public static function canRestore(Model $record): bool
    {
        return static::canDelete($record);
    }

    public static function canForceDelete(Model $record): bool
    {
        return static::canDelete($record);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->with(['task.project', 'user']);

        $user = auth()->user();

        if (! $user instanceof User) {
            return $query->whereKey([]);
        }

        if ($user->role === UserRole::ADMIN) {
            return $query;
        }

        if ($user->role === UserRole::MANAGER) {
            return $query->whereHas('task.project', function (Builder $projectQuery) use ($user): void {
                $projectQuery->where('created_by', $user->id);
            });
        }

        if ($user->role === UserRole::DEVELOPER) {
            return $query->whereHas('task', function (Builder $taskQuery) use ($user): void {
                $taskQuery->where('assigned_to', $user->id);
            });
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
            'index' => ListComments::route('/'),
            'create' => CreateComment::route('/create'),
            'edit' => EditComment::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return static::getEloquentQuery();
    }

    private static function userCanManageRecord(User $user, Comment $comment): bool
    {
        if ($user->role === UserRole::ADMIN) {
            return true;
        }

        if ($user->role === UserRole::MANAGER) {
            return $comment->task()
                ->whereHas('project', function (Builder $projectQuery) use ($user): void {
                    $projectQuery->where('created_by', $user->id);
                })
                ->exists();
        }

        return $user->role === UserRole::DEVELOPER
            && (int) $comment->user_id === (int) $user->id
            && $comment->task()->where('assigned_to', $user->id)->exists();
    }
}
