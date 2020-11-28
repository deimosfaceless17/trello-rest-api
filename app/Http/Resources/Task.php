<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Task extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'board_id' => $this->board_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'desktop_image' => new Image($this->desktopImage),
            'mobile_image' => new Image($this->mobileImage),
        ];
    }
}
