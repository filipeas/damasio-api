<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategory extends FormRequest
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
            'title' => ['required', 'min:3', 'max:30'],
            'propaganda' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'title_color' => ['nullable', 'min:3', 'max:6'],
            'color' => ['nullable', 'min:3', 'max:6'],
            'model' => ['nullable', 'bool'],
        ];
    }
}
