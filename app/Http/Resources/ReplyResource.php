<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
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
            'reply' => $this->body,
            'user' => $this->user->name,
            'user_id' => $this->user->id,
            'likes_count' => $this->likes->count(),
            'user_likes' => $this->likes->pluck('user_id'),
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
