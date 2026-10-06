<?php

namespace App\Http\Resources;


use App\Enums\Status;
use App\Libraries\AppLibrary;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemAddonResource extends JsonResource
{

    public $variation = 0;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */


    public function toArray($request)
    {
        $this->variation = $this->variationTotal();
        $price           = optional($this->addonItem)->price ?? 0;
        $offer           = $this->addonItem?->offer ? $this->addonItem->offer->filter(function ($offer) use ($price) {
            if (AppLibrary::isBetweenDate(
                $offer->start_date,
                $offer->end_date
            ) && $offer->status == Status::ACTIVE) {
                $amount                = ($price - ($price / 100 * $offer->amount));
                $offer->flat_price     = AppLibrary::flatAmountFormat($amount);
                $offer->convert_price  = AppLibrary::convertAmountFormat($amount);
                $offer->currency_price = AppLibrary::currencyAmountFormat($amount);
                return $offer;
            }
        }) : collect();
        if (!$offer) {
            $offer = collect();
        }
        $firstOffer      = ($offer && $offer->isNotEmpty()) ? $offer->first() : null;
        $addonPrice      = optional($this->addonItem)->price ?? 0;
        $total           = (optional($this->variation)->price ?? 0) + ($firstOffer ? $firstOffer->convert_price : $addonPrice);
        return [
            'id'                             => $this->id,
            'item_id'                        => $this->item_id,
            'item_addon_id'                  => $this->addon_item_id,
            'item_name'                      => optional($this->item)->name,
            'addon_item_name'                => optional($this->addonItem)->name,
            'addon_item_price'               => optional($this->addonItem)->price ?? 0,
            "addon_item_flat_price"          => AppLibrary::flatAmountFormat(optional($this->addonItem)->price ?? 0),
            "addon_item_convert_price"       => AppLibrary::convertAmountFormat(optional($this->addonItem)->price ?? 0),
            "addon_item_currency_price"      => AppLibrary::currencyAmountFormat(optional($this->addonItem)->price ?? 0),
            'addon_item_status'              => optional($this->addonItem)->status,
            'variations'                     => json_decode($this->addon_item_variation ?? '[]'),
            'variation_total'                => optional($this->variation)->price ?? 0,
            "variation_total_flat_price"     => AppLibrary::flatAmountFormat(optional($this->variation)->price ?? 0),
            "variation_total_convert_price"  => AppLibrary::convertAmountFormat(optional($this->variation)->price ?? 0),
            "variation_total_currency_price" => AppLibrary::currencyAmountFormat(optional($this->variation)->price ?? 0),
            'total'                          => $total,
            "total_flat_price"               => AppLibrary::flatAmountFormat($total),
            "total_convert_price"            => AppLibrary::convertAmountFormat($total),
            "total_currency_price"           => AppLibrary::currencyAmountFormat($total),
            'variation_names'                => optional($this->variation)->name ?? [],
            'thumb'                          => optional($this->addonItem)->thumb,
            'cover'                          => optional($this->addonItem)->cover,
            'preview'                        => optional($this->addonItem)->preview,
            'caution'                        => optional($this->addonItem)->caution ?? '',
            'offer'                          => SimpleOfferResource::collection($offer)
        ];
    }

    private function variationTotal()
    {
        $variationArray = $this->addonItem?->variations ? $this->addonItem->variations->mapWithKeys(function ($variation) {
            return [$variation->id => $variation];
        }) : collect();
        if ($this->addon_item_variation) {
            $variations = (object) json_decode($this->addon_item_variation, true);
            $price      = 0;
            $name       = [];
            foreach ($variations as $variation) {
                if (isset($variationArray[$variation])) {
                    $name[] = [
                        'id'             => $variationArray[$variation]->id,
                        'name'           => $variationArray[$variation]->name,
                        'attribute_name' => optional($variationArray[$variation]->itemAttribute)->name ?? ''
                    ];
                    $price  += $variationArray[$variation]->price;
                }
            }
            return (object)[
                'price' => $price,
                'name'  => $name
            ];
        }
        return (object)[
            'price' => 0,
            'name'  => []
        ];
    }
}
