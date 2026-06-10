<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'expense_category_id' => ['required', 'integer', Rule::exists('expense_categories', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'max:8'],
            'day' => ['required', 'integer', 'min:1', 'max:31'],
            'month' => ['required', 'integer', 'between:1,12'],
            'year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $day = (int) $this->input('day');
            $month = (int) $this->input('month');
            $year = (int) $this->input('year');

            if (! checkdate($month, $day, $year)) {
                $validator->errors()->add('day', 'Please choose a valid day for the selected month and year.');
            }
        });
    }

    protected function prepareForValidation(): void
    {
        if (! $this->filled('currency')) {
            $this->merge(['currency' => 'RWF']);
        }
    }

    protected function getRedirectUrl(): string
    {
        if ($this->boolean('from_index')) {
            return route('admin.expenses.index', [
                'year' => max(2000, min(2100, (int) $this->input('year', now()->year))),
                'tab' => 'add',
            ]);
        }

        return parent::getRedirectUrl();
    }
}
