<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PanicResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */

    public static $wrap = 'scan';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'panic_type' => $this->panic_type,
            'details' => $this->details,
            'created_at' => (string) $this->created_at,
            'created_by' => new UserResource($this->user),
        ];
    }
}


