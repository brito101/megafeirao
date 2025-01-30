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
            'social_name' => 'nullable|min:5|max:191',
            // 'alias_name' => 'required',
            // 'headline' => 'required',
            'cover' => 'image',
            'cover1' => 'image',
            // Address
            'zipcode' => 'nullable|min:8|max:10',
            'street' => 'nullable',
            'number' => 'nullable',
            'neighborhood' => 'nullable',
            'state' => 'required',
            'city' => 'required',
            'telephone' => 'nullable|max:20',
            'cell' => 'required|max:20',
            'cell2' => 'nullable|max:20',
            'email' => 'required',
            'main_banner' => 'nullable|image|mimes:jpg,png,jpeg|max:1024',
            'banner1' => 'nullable|image|mimes:jpg,png,jpeg|max:1024',
            'banner2' => 'nullable|image|mimes:jpg,png,jpeg|max:1024',
            'banner3' => 'nullable|image|mimes:jpg,png,jpeg,|max:1024',
            'type' => 'nullable|in:concessionaria,particular',
            'slug' => 'required|min:5|max:191|string|unique:companies,slug|regex:/^[a-z0-9-]+$/',
        ];
    }
}
