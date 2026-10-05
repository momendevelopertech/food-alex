<?php

namespace App\Http\Resources;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemAttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request) : array
    {
        // This resource is used both with ItemAttribute models (admin listing) and with
        // lightweight stdClass objects built from variations (embedded in ItemResource).
        // getRawOriginal()/whenLoaded() only exist on the model, so guard for both.
        $isModel = $this->resource instanceof Model;

        return [
            'id'           => $this->id,
            'name'         => $isModel ? $this->resource->getRawOriginal('name') : ($this->resource->name ?? null),
            'status'       => $this->status,
            'translations' => $isModel ? $this->whenLoaded('translations', $this->translations) : [],
        ];
    }

}
