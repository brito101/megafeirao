<?php

namespace LaraCar\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Banner extends FormRequest
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
            'cover1' => 'image',
            'link1' => 'url',
            'cover2' => 'image',
            'link2' => 'url',
            'cover3' => 'image',
            'link3' => 'url',
            'cover4' => 'image',
            'link4' => 'url',
        ];
    }
}
