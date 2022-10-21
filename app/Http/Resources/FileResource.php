<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'description' => $this->description,
            'date_time' => (new Carbon($this->created_at))->format('d/m/Y H:i'),
            'url' => route('downloadFile', ['vc' => $this->videoconsultation->secret, 'id' => $this->id])
        ];
    }
}
