<?php

namespace App\Filament\Resources\Comments\Schemas;

use App\Enums\UserRole;
use App\Models\User;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('task_id')
                    ->relationship(
                        name: 'task',
                        titleAttribute: 'title',
                        modifyQueryUsing: function (Builder $query): void {
                            $user = auth()->user();

                            if (! $user instanceof User) {
                                $query->whereKey([]);

                                return;
                            }

                            if ($user->role === UserRole::MANAGER) {
                                $query->whereHas('project', function (Builder $projectQuery) use ($user): void {
                                    $projectQuery->where('created_by', $user->id);
                                });

                                return;
                            }

                            if ($user->role === UserRole::DEVELOPER) {
                                $query->where('assigned_to', $user->id);
                            }
                        },
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Hidden::make('user_id')
                    ->default(fn (): ?int => auth()->id())
                    ->required(),
                Textarea::make('comment')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
