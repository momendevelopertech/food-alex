<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryCodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (blank($this->resource)) {
            return [
                'calling_code' => '+20',
                'flag_emoji' => '🇪🇬',
                'flag_svg' => '',
                'flag_svg_path' => '',
                'capital' => 'Cairo',
                'nationality' => 'Egyptian',
            ];
        }

        $callingCode = '+20';
        try {
            if (!empty($this->calling_codes) && isset($this->calling_codes[0])) {
                $callingCode = $this->calling_codes[0] == '+1201' ? '+1' : $this->calling_codes[0];
            }
        } catch (\Throwable $e) {
            $callingCode = '+20';
        }

        return [
            'calling_code' => $callingCode,
            'flag_emoji' => $this->extra->emoji ?? '🇪🇬',
            'flag_svg' => $this->extra->svg ?? '',
            'flag_svg_path' => $this->extra->svg_path ?? '',
            'capital' => $this->capital_rinvex ?? '',
            'nationality' => $this->demonym ?? '',
        ];
    }
}
