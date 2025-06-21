<?php

namespace Crater\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'billing' => new AddressResource($this->whenLoaded('billingAddress')),
            'shipping' => new AddressResource($this->whenLoaded('shippingAddress')),
            'formatted_review_date' => $this->getFormattedReviewDate(),
        ]);
    }

    private function getFormattedReviewDate()
    {
        if (!$this->review_date) {
            return null;
        }
        $dateFormat = \Crater\Models\CompanySetting::getSetting('carbon_date_format', $this->company_id);
        return \Carbon\Carbon::parse($this->review_date)->format($dateFormat);
    }
}
