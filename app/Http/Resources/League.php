<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class League extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'number_dates' => $this->number_dates,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'teams' => new TeamCollection($this->teams),
            ],
        ];
    }
}
