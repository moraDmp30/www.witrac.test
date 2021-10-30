<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'frequency' => $this->frequency,
            'command' => $this->command,
            'is_running' => $this->is_running,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        return parent::toArray($request);
    }
}
