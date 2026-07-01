<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'role_id' => $this->role_id,
            'name' => $this->name,
            'email' => $this->email,
            'dob' => $this->dob?->toDateString(),
            'credit_score' => $this->credit_score,
            'employment_type' => $this->employment_type,
            'salary_type' => $this->salary_type,
            'salary' => $this->salary,
            'status' => $this->status,
            'role' => RoleResource::make($this->role),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
