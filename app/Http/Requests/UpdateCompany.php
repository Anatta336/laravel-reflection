<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validation rules for updating a company.
 *
 * @package Company
 */
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
            'logo-file' => 'nullable|mimetypes:image/*|dimensions:min_width=100,min_height=100|max:5120',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
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
            'logo-file.mimetypes' => 'The logo must be an image file.',
            'logo-file.dimensions' => 'The logo image must be at least 100px in width and height.',
            'logo-file.max' => 'The logo image cannot be more than 5MB in size.',
            'email.email' => 'Invalid email address.',
            'website.url' => 'Invalid URL.',
        ];
    }
}
