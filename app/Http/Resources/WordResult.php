<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WordResult extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (isset($this[0])) {
            return [
                'learnedTimes' => (isset($this[0]->pivot->learned_times)) ? $this[0]->pivot->learned_times : null,
                'lastAnswered' =>  (isset($this[0]->pivot->last_time_learned)) ? $this[0]->pivot->last_time_learned : null
            ];
        }
    }
}
