<?php

namespace Crater\Http\Requests;

use Crater\Models\Address;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => [
                'required',
            ],
            'email' => [
                'email',
                'nullable',
                Rule::unique('customers')->where('company_id', $this->header('company'))
            ],
            'password' => [
                'nullable',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
            ],
            'company_name' => [
                'nullable',
            ],
            'contact_name' => [
                'nullable',
            ],
            'website' => [
                'nullable',
            ],
            'prefix' => [
                'nullable',
            ],
            'enable_portal' => [

                'boolean'
            ],
            'currency_id' => [
                'nullable',
            ],
            'age' => [
                'nullable',
                'integer',
                'min:0',
                'max:150',
            ],
            'next_of_kin' => [
                'nullable',
                'string',
                'max:255',
            ],
            'next_of_kin_phone' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
            ],
            'diagnosis' => [
                'nullable',
                'string',
            ],
            'treatment' => [
                'nullable',
                'string',
            ],
            'attended_by' => [
                'nullable',
                'string',
                'max:255',
            ],
            'review_date' => [
                'nullable',
                'date',
                'after_or_equal:today',
            ],
            'billing.name' => [
                'nullable',
            ],
            'billing.address_street_1' => [
                'nullable',
            ],
            'billing.address_street_2' => [
                'nullable',
            ],
            'billing.city' => [
                'nullable',
            ],
            'billing.state' => [
                'nullable',
            ],
            'billing.country_id' => [
                'nullable',
            ],
            'billing.zip' => [
                'nullable',
            ],
            'billing.phone' => [
                'nullable',
            ],
            'billing.fax' => [
                'nullable',
            ],
            'shipping.name' => [
                'nullable',
            ],
            'shipping.address_street_1' => [
                'nullable',
            ],
            'shipping.address_street_2' => [
                'nullable',
            ],
            'shipping.city' => [
                'nullable',
            ],
            'shipping.state' => [
                'nullable',
            ],
            'shipping.country_id' => [
                'nullable',
            ],
            'shipping.zip' => [
                'nullable',
            ],
            'shipping.phone' => [
                'nullable',
            ],
            'shipping.fax' => [
                'nullable',
            ]
        ];

        if ($this->isMethod('PUT') && $this->email != null) {
            $rules['email'] = [
                'email',
                'nullable',
                Rule::unique('customers')->where('company_id', $this->header('company'))->ignore($this->route('customer')->id),
            ];
        };

        return $rules;
    }

    public function getCustomerPayload()
    {
        return collect($this->validated())
            ->only([
                'name',
                'email',
                'currency_id',
                'password',
                'phone',
                'prefix',
                'company_name',
                'contact_name',
                'website',
                'enable_portal',
                'estimate_prefix',
                'payment_prefix',
                'invoice_prefix',
                'age',
                'next_of_kin',
                'next_of_kin_phone',
                'diagnosis',
                'treatment',
                'attended_by',
                'review_date',
            ])
            ->merge([
                'creator_id' => $this->user()->id,
                'company_id' => $this->header('company'),
            ])
            ->toArray();
    }

    public function getShippingAddress()
    {
        return collect($this->shipping)
            ->merge([
                'type' => Address::SHIPPING_TYPE
            ])
            ->toArray();
    }

    public function getBillingAddress()
    {
        return collect($this->billing)
            ->merge([
                'type' => Address::BILLING_TYPE
            ])
            ->toArray();
    }

    public function hasAddress(array $address)
    {
        $data = Arr::where($address, function ($value, $key) {
            return isset($value);
        });

        return $data;
    }

    public function messages()
    {
        return [
            'age.integer' => 'Age must be a whole number.',
            'age.min' => 'Age cannot be negative.',
            'age.max' => 'Age cannot exceed 150 years.',
            'next_of_kin.max' => 'Next of kin name cannot exceed 255 characters.',
            'next_of_kin_phone.regex' => 'Next of kin phone number format is invalid.',
            'next_of_kin_phone.max' => 'Next of kin phone number cannot exceed 255 characters.',
            'attended_by.max' => 'Attended by field cannot exceed 255 characters.',
            'review_date.date' => 'Review date must be a valid date.',
            'review_date.after_or_equal' => 'Review date must be today or a future date.',
        ];
    }
}
