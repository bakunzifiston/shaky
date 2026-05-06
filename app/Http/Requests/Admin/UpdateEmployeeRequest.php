<?php

namespace App\Http\Requests\Admin;

use App\Support\RwandaLocations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employeeId = $this->route('employee')?->id;
        $districtOptions = RwandaLocations::districtOptions((string) $this->input('province'));

        return [
            'employee_id' => ['required', 'string', 'max:255', Rule::unique('employees', 'employee_id')->ignore($employeeId)],
            'name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'province' => ['nullable', Rule::in(array_keys(RwandaLocations::provinces()))],
            'district' => ['required', Rule::in(array_keys($districtOptions))],
            'photo' => ['nullable', 'image', 'max:4096'],
        ];
    }
}
