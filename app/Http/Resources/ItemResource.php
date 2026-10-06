<?php

namespace App\Http\Resources;


use App\Enums\Status;
use App\Libraries\AppLibrary;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdminItemCategoryResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $price = $this->price;
        return [
            "id"               => $this->id,
            "name"             => $this->resource->getRawOriginal('name'),
            "slug"             => $this->slug,
            "item_category_id" => $this->item_category_id,
            "tax_id"           => $this->tax_id,
            "flat_price"       => AppLibrary::flatAmountFormat($this->price),
            "convert_price"    => AppLibrary::convertAmountFormat($this->price),
            "currency_price"   => AppLibrary::currencyAmountFormat($this->price),
            "price"            => $this->price,
            "item_type"        => $this->item_type,
            "is_featured"      => $this->is_featured,
            "status"           => $this->status,
            "description"      => $this->resource->getRawOriginal('description') ?? '',
            "caution"          => $this->resource->getRawOriginal('caution') ?? '',
            "order"            => $this->orders->count(),
            "thumb"            => $this->thumb,
            "cover"            => $this->cover,
            "preview"          => $this->preview,
            "category_name"    => optional($this->category)->getRawOriginal('name'),
            "category"         => new AdminItemCategoryResource($this->category),
            "tax"              => new TaxResource($this->tax),
            "variations"       => $this->variations ? $this->variations->groupBy('item_attribute_id') : collect(),
            "itemAttributes"   => ItemAttributeResource::collection($this->itemAttributeList($this->variations)),
            "extras"           => ItemExtraResource::collection($this->extras ? $this->extras->load('item') : collect()),
            "addons"           => ItemAddonResource::collection($this->addons ? $this->addons->load('addonItem') : collect()),
            "translations"     => $this->whenLoaded('translations', $this->translations),
            "offer"            => SimpleOfferResource::collection(
                $this->offer ? $this->offer->filter(function ($offer) use ($price) {
                    if (AppLibrary::isBetweenDate($offer->start_date, $offer->end_date) && $offer->status === Status::ACTIVE) {
                        $amount                = ($price - ($price / 100 * $offer->amount));
                        $offer->flat_price     = AppLibrary::flatAmountFormat($amount);
                        $offer->convert_price  = AppLibrary::convertAmountFormat($amount);
                        $offer->currency_price = AppLibrary::currencyAmountFormat($amount);
                        return $offer;
                    }
                }) : collect()
            )
        ];
    }

    private function itemAttributeList($variations)
    {
        $array = [];
        if ($variations) {
            foreach ($variations as $b) {
                if ($b->itemAttribute && !isset($array[$b->itemAttribute->id])) {
                    $array[$b->itemAttribute->id] = (object)[
                        'id'     => $b->itemAttribute->id,
                        'name'   => $b->itemAttribute->name,
                        'status' => $b->itemAttribute->status
                    ];
                }
            }
        }
        return collect($array);
    }
}
