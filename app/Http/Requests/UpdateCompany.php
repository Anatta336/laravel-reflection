<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCompany extends FormRequest
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
        return [
            'name' => 'required',
            'logo-file' => 'nullable|dimensions:min_width=100,min_height=100',
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
            'name.required' => 'A company name is required.',
            'logo-file.dimensions' => 'The logo image must be at least 100px in width and height.',
        ];
    }
}
