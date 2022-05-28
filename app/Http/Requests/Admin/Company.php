<?php

namespace LaraCar\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Company extends FormRequest
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
            'social_name' => 'required|min:5|max:191',
            // 'alias_name' => 'required',
            // 'headline' => 'required',
            'cover' => 'image',
            'cover1' => 'image',
            // Address
            'zipcode' => 'required|min:8|max:10',
            'street' => 'required',
            'number' => 'required',
            'neighborhood' => 'required',
            'state' => 'required',
            'city' => 'required',
            'telephone' => 'required',
            'cell' => 'required',
            'email' => 'required',
            'main_banner' => 'nullable|image|mimes:jpg,png,jpeg|max:1024|dimensions:max_width=1900,max_height=300',
            'banner1' => 'nullable|image|mimes:jpg,png,jpeg|max:1024|dimensions:max_width=1900,max_height=600',
            'banner2' => 'nullable|image|mimes:jpg,png,jpeg|max:1024|dimensions:max_width=1900,max_height=600',
            'banner3' => 'nullable|image|mimes:jpg,png,jpeg,|max:1024|dimensions:max_width=1900,max_height=600'
        ];
    }
}
