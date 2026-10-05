<?php

namespace App\Http\Resources;

use App\Enums\Status;
use App\Libraries\AppLibrary;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminSimpleItemResource extends JsonResource
{
    public function toArray($request)
    {
        $price = $this->price;
        return [
            "id"               => $this->id,
            "name"             => $this->resource->getRawOriginal('name'),
            "slug"             => $this->slug,
            "item_category_id" => $this->item_category_id,
            "tax_id"           => $this->tax_id,
            "is_featured"      => $this->is_featured,
            "flat_price"       => AppLibrary::flatAmountFormat($this->price),
            "convert_price"    => AppLibrary::convertAmountFormat($this->price),
            "currency_price"   => AppLibrary::currencyAmountFormat($this->price),
            "price"            => $this->price,
            "item_type"        => $this->item_type,
            "status"           => $this->status,
            "description"      => $this->resource->getRawOriginal('description') ?? '',
            "caution"          => $this->resource->getRawOriginal('caution') ?? '',
            "thumb"            => $this->thumb,
            "cover"            => $this->cover,
            "preview"          => $this->preview,
            "category_name"    => optional($this->category)->getRawOriginal('name'),
            "offer"            => SimpleOfferResource::collection(
                $this->offer->filter(function ($offer) use ($price) {
                    if (AppLibrary::isBetweenDate($offer->start_date, $offer->end_date) && $offer->status === Status::ACTIVE) {
                        $offer->flat_price     = AppLibrary::flatAmountFormat($price - ($price / 100 * $offer->amount));
                        $offer->convert_price  = AppLibrary::convertAmountFormat($price - ($price / 100 * $offer->amount));
                        $offer->currency_price = AppLibrary::currencyAmountFormat($price - ($price / 100 * $offer->amount));
                        return $offer;
                    }
                })
            )
        ];
    }
}
