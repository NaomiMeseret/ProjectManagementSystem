<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public static function shouldRegisterNavigation(): bool
    {
    $user = auth()->user();

    return in_array($user->role, ['admin', 'manager', 'developer']);
    }
   public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status->value,
            'deadline' => $this->deadline?->toDateString(),
            'created_by' => $this->created_by,
            'created_by_name' => $this->whenLoaded('creator', fn () => $this->creator?->name),
            'creator' => $this->whenLoaded('creator', function () {
                return [
                    'id' => $this->creator->id,
                    'name' => $this->creator->name,
                    'email' => $this->creator->email,
                    'role' => $this->creator->role?->value,
                ];
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
