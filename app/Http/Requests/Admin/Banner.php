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
            'link1' => 'url|nullable',
            'cover2' => 'image',
            'link2' => 'url|nullable',
            'cover3' => 'image',
            'link3' => 'url|nullable',
            'cover4' => 'image',
            'link4' => 'url|nullable',
            'cover5' => 'image',
            'link5' => 'url|nullable',
            'cover6' => 'image',
            'link6' => 'url|nullable',
            'cover7' => 'image',
            'link7' => 'url|nullable',
            'cover8' => 'image',
            'link8' => 'url|nullable',
            'cover9' => 'image',
            'link9' => 'url|nullable',
        ];
    }
}
