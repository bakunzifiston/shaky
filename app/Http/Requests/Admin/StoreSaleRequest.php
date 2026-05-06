<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_Phone' => ['nullable', 'string', 'max:255'],
            'invoice_number' => ['nullable', 'string', 'max:255'],
            'sale_date' => ['required', 'date'],
            'payment_status' => ['required', Rule::in(['Paid', 'Pending', 'Credit'])],
            'delivery_status' => ['required', Rule::in(['Delivered', 'Pending', 'In Transit'])],
            'sales_channel' => ['required', Rule::in(['Momo Pay', 'Card', 'Cash'])],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.production_id' => ['required', 'exists:productions,id'],
            'items.*.quantity_sold' => ['required', 'numeric', 'gt:0'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
