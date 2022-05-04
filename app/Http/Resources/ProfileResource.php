<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $token = $this->createToken('auth_token')->plainTextToken;

        return [
            'name'          => $this->name,
            'email'         => $this->email,
            'role'          => $this->roles->pluck('name')->first(),
            'token'         => $token,
        ];
    }
}
