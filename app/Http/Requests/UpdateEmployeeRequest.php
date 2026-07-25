<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:50',
            'email'          => 'required|email|unique:users,email,' . $this->employee->user->id,
            'phone'          => 'required|string|unique:users,phone,' . $this->employee->user->id,
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp,gif',
            'department_id'  => 'required|integer|exists:departments,id',
            'designation_id' => 'required|integer|exists:designations,id',
            'employee_code'  => 'required|string|unique:employees,employee_code,' . $this->employee->id,
            'sick_leave'     => 'required|integer',
            'paid_leave'     => 'required|integer',
            'casual_leave'   => 'required|integer', 
        ];
    }
}
