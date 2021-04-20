<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePDFForACategory extends FormRequest
{
    public function response(array $errors)
    {
        return response()->json($errors, 422);
    }

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
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ];
    }
}
