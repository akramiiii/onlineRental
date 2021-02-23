<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NationalCode implements Rule
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
        $sum=0;
        for ($i=0;$i<9;$i++) {
            $n=intval(substr($value, $i, 1));
            $sum+=(10-$i)*$n;
        }
        $ret=$sum%11;
        $parity=intval(substr($value, 9, 1));
        if (($ret<2 && $ret==$parity) || ($ret>2 && $ret==(11-$parity))) {
            return  true;
        } else {
            return  false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'کد ملی وارد شده صحیح نمی باشد';
    }
}
