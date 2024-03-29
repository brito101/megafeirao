<?php

namespace LaraCar\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClientBannerRequest extends FormRequest
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
            'cover1' => 'nullable|image|mimes:jpg,png,jpeg,|max:1024'
        ];
    }
}
