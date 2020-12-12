<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class InquiryRequest extends FormRequest
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
            //
            'name'  => ['required','string'],
            'email' => ['required', 'email'],
            'relations' => ['required' , Rule::in(config('relations'))],
            'content' => ['required' , 'string'],
        ];
        
    }
    
     public function attributes(){
         
         return [
             
            'name'  => 'お名前',
            'email' => 'メール',
            'relations' => '関係',
            'content' => '伝えたいこと',
            
             ];
     }
}
