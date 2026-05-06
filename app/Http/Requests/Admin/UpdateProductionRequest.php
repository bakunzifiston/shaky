<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'batch_id' => ['nullable', 'string', 'max:255'],
            'product_id' => ['required', 'exists:products,id'],
            'barcode' => ['required', 'string', 'max:255'],
            'quantity_produced' => ['required', 'numeric'],
            'damaged' => ['required', 'numeric'],
            'production_date' => ['required', 'date'],
            'responsible_staff' => ['nullable', 'string', 'max:255'],
            'quality_control_notes' => ['nullable', 'string'],
            'inventory_record_id' => ['required', 'array', 'min:1'],
            'inventory_record_id.*.inventory_id' => ['required', 'exists:inventory_records,id'],
            'inventory_record_id.*.quantity_used' => ['required', 'numeric', 'gt:0'],
        ];
    }
}
