<?php

namespace LaraCar\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class User extends FormRequest
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

    public function prepareForValidation()
    {
        $this->merge([
            'ads_limit' => $this->ads_limit ? $this->ads_limit : 0,
            'banner_views_limit' => $this->banner_views_limit ? $this->ads_limit : 0,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:191',
            'cell' => 'required|min:10|max:191',
            'cover' => 'image',
            'email' => (!empty($this->request->all()['id']) ? 'required|email|unique:users,email,' . $this->request->all()['id'] : 'required|email|unique:users,email'),
            'ads_limit' => 'nullable|numeric',
            'banner_views_limit' => 'nullable|numeric',
        ];
    }
}
