<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // respons ketika berhasil dan kita ingin sesuai dengan API spec yang kita buat
        return [
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            //jika token tidak null akan ditampilkan di token ini maskdunya di $this->token
            'token' => $this->whenNotNull($this->token),

        ];

    }
}
