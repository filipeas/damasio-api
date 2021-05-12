<?php

namespace App\Http\Requests;

use App\Rules\CheckIfBrandCodeUpdate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrand extends FormRequest
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
            'code' => ['required', new CheckIfBrandCodeUpdate($this->brand)],
            'title' => ['required', 'min:3', 'max:30'],
        ];
    }
}
