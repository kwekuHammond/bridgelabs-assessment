<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'externalId' => $this->external_id,
            'originalName' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'mime' => $this->mime,
            'path' =>$this->path,
            'url' => $this->url,
        ];
    }
}
