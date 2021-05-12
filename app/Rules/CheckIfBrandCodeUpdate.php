<?php

namespace App\Rules;

use App\Brand;
use Illuminate\Contracts\Validation\Rule;

class CheckIfBrandCodeUpdate implements Rule
{
    private $brand;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($brand)
    {
        $this->brand = $brand;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $brand = Brand::where('code', $value)->where('id', $this->brand)->first();

        if (is_null($brand))
            return false;

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Você não pode usar um código de outra marca.';
    }
}
