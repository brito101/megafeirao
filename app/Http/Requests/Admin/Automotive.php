<?php

namespace LaraCar\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Automotive extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user' => 'required',
            'category' => 'required|in:Carro,Moto,Caminhão,Ônibus,Náutica,Agrícola',
            'sale_price' => 'required',
            'description' => 'required',
            'model' => 'required',
            'brand' => 'required',
            'year' => 'required',
            'mileage' => 'required',
            'youtube_link' => 'nullable|url'
        ];
    }
}
