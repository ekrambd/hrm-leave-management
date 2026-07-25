<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequest extends FormRequest
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
        $rules = [
            
            'type'  => 'required|in:sick,paid,unpaid,casual,special_consideration',
        ];

        if (user()->role_id == 1) {
            $rules['leave_review'] = 'required';
            $rules['status'] = 'required|in:pending,approved,rejected';
        } elseif(user()->role_id == 2) {
            $rulses['from_date']    = 'required|date_format:Y-m-d';
            $rulses['to_date']    = 'required|date_format:Y-m-d';
            $rules['leave_reason'] = 'required';
            $rules['status'] = 'nullable|in:pending,approved,rejected';
        }

        return $rules;
    }
}
