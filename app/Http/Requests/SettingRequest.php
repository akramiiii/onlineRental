<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
        if($this->isMethod('post')){
            $ruels = [
                'send_time' => 'required|numeric',
                'send_price' => 'required|numeric',
                'min_order_price' => 'required|numeric',
            ];
            return $ruels;
        }
        else{
            return [];
        }
    }

    public function attributes()
    {
        return[
            'send_time' => 'زمان حدودی ارسال سفارش',
            'send_price' => 'هزینه ارسال سفارش',
            'min_order_price' => 'حداقل خرید برای ارسال رایگان',
        ];
    }

    public function messages()
    {
        return[
            'search_url.required' => 'برای دسته باید نام انگلیسی یا url ثبت شود'
        ];
    }

    protected function getValidatorInstance()
    {
        if($this->request->has('send_time'))
        {
            $this->merge([
                'send_time'=>str_replace(',','',$this->request->get('send_time'))
            ]);
        }
        if($this->request->has('send_price'))
        {
            $this->merge([
                'send_price'=>str_replace(',','',$this->request->get('send_price'))
            ]);
        }
        if($this->request->has('min_order_price'))
        {
            $this->merge([
                'min_order_price'=>str_replace(',','',$this->request->get('min_order_price'))
            ]);
        }

        return parent::getValidatorInstance();
    }
}
