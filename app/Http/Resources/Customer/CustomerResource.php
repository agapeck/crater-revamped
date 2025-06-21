<?php

namespace Crater\Http\Resources\Customer;

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
            'billing' => $this->when($this->billingAddress()->exists(), function () {
                return new AddressResource($this->billingAddress);
            }),
            'shipping' => $this->when($this->shippingAddress()->exists(), function () {
                return new AddressResource($this->shippingAddress);
            }),
            'formatted_review_date' => $this->getFormattedReviewDate(),
            'fields' => $this->when($this->fields()->exists(), function () {
                return CustomFieldValueResource::collection($this->fields);
            }),
            'company' => $this->when($this->company()->exists(), function () {
                return new CompanyResource($this->company);
            }),
            'currency' => $this->when($this->currency()->exists(), function () {
                return new CurrencyResource($this->currency);
            }),
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
