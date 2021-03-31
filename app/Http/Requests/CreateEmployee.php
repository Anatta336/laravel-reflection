<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Validation for creating an employee.
 *
 * @package Employee
 */
class CreateEmployee extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // authorization handled by middleware
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id' => 'nullable|exists:companies,id',
            'email' => 'nullable|email',
            'phone' => ['nullable', new PhoneNumber()],
        ];
    }

    /**
     * Get the error messages for if validation rules do not pass.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'A first name is required.',
            'last_name.required' => 'A last name is required.',
            'company_id.exists' => 'Invalid company ID.',
            'email.email' => 'Invalid email address.',
            // PhoneNumber rule already creates meaningful messages
        ];
    }
}
