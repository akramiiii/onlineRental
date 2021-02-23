<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BankCode implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        if (strlen($value)==16) {
            $sum=0;
            for ($i=0;$i<strlen($value);$i++) {
                $n=intval($value[$i]);
                if (checkEven($i)) {
                    $n=$n*2;
                    if ($n>9) {
                        $n=$n-9;
                    }
                }
                $sum=$sum+$n;
            }

            if ($sum%2==0) {
                return  true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'شماره کارت وارد معتبر نمی باشد';
    }
}
