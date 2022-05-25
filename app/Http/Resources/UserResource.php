<?php
 
namespace App\Http\Resources;

use App\Http\Resources\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;
 
class UserResource extends JsonResource
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
            'date' => $this->date,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => new AddressResource($this->whenLoaded('address')),
        ];
    }
}