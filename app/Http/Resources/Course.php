<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Word as WordResource;

class Course extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'language' => $this->language,
            'words' => WordResource::collection($this->whenLoaded('words')),
            'global' => (!$this->user),
            'author' => ($this->user) ? (new UserResource($this->user))->only('id', 'name', 'avatar_url') : null,
            'usersResult' => ($this->whenLoaded('user_resource')) ? true : false
        ];
    }
}
