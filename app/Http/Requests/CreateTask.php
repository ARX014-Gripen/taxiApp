<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTask extends FormRequest
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

    public function attributes()
    {
        return [
            'car_id' => '号車', 
            'money' => '売上',
            'date' => '日付',
            'origin' => '出発地点',
            'destination' => '到着地点',
        ];
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
            'car_id' => 'required', // ★
            'money' => 'required', // ★
            'date' => 'required', // ★
            'origin' => 'required', // ★
            'destination' => 'required', // ★
        ];
    }
}
