<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ProjectStatus;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'created_by',
        'deadline',
        'status',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function creator()
    {
            return $this->belongsTo(User::class,'created_by');
        }
    protected $casts = [
        'status' => ProjectStatus::class,
    ];
}
