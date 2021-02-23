<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CartProductCount implements Rule
{
    protected $total;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($total)
    {   
        $this->total = $total;
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
        if($value > $this->total && $this->total > 0){
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'تعداد قابل سفارش در هر سبد خرید نباید از موجودی کالا بزرگتر باشد';
    }
}
