<?php

namespace App\Http\Requests;

use App\Rules\BankCart;
use App\Rules\BankCode;
use App\Rules\NationalCode;
use App\Rules\ValidateMobileNumber;
use Illuminate\Foundation\Http\FormRequest;

class AdditionalRequest extends FormRequest
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
        $rules=[
            'first_name'=>['required'],
            'last_name'=>['required'],
            'national_identity_number'=>['required'],
            'mobile_phone'=>['required',new ValidateMobileNumber()]
        ];
        if (!empty($this->bank_card_number)) {
            $rules['bank_card_number']=['string','size:16',new BankCode()];
        }
        if (!empty($this->email)) {
            $rules['email']=['required','email'];
        }
        return $rules;
    }
    public function attributes()
    {
        return [
            'national_identity_number'=>'کد ملی',
            'bank_card_number'=>'شماره کارت',
            'city_id'=>'شهر',
            'province_id'=>'استان',
        ];
    }
}
