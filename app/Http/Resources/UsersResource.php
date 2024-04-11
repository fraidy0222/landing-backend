<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'last_name' => $this->last_name,
            'email' => $this->email,
            // 'password' => $this->password,
            'role' => $this->roleToArray(),
            'is_active' => $this->is_active,
        ];
    }

    protected function roleToArray()
    {
        return explode(",", $this->role);
    }
}
