<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => [
                'required',
                Rule::in(array_column(TaskStatus::cases(), 'value')),
            ],
            'priority' => [
                'required',
                Rule::in(array_column(TaskPriority::cases(), 'value')),
            ],
            'assigned_to' => [
                'required',
                Rule::exists('users', 'id')
                    ->where('role', UserRole::DEVELOPER->value),
            ],
        ];
    }
}
