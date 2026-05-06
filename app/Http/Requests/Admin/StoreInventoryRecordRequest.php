<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInventoryRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_name' => ['required', 'string', 'max:255'],
            'invoice_number' => ['nullable', 'string', 'max:255'],
            'item_type' => ['required', Rule::in(['Product', 'Raw Material'])],
            'item_name' => ['required', 'string', 'max:255'],
            'product_id' => ['nullable', 'exists:products,id'],
            'quantity_in' => ['required', 'numeric'],
            'quantity_out' => ['required', 'numeric'],
            'unit_cost' => ['nullable', 'numeric', 'min:0'],
            'damaged' => ['required', 'numeric'],
            'storage_location' => ['required', 'string', 'max:255'],
            'record_date' => ['required', 'date'],
            'total_amount' => ['nullable', 'numeric'],
            'amount_paid' => ['nullable', 'numeric'],
            'payment_status' => ['required', Rule::in(['Paid', 'Partial', 'Unpaid'])],
            'payment_due_date' => ['nullable', 'date'],
        ];
    }
}
