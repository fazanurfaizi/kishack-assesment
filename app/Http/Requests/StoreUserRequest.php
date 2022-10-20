<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:100|unique:users,username',
            'email'=> 'required|email|unique:users,email',
            'password' => 'required|string',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
            'role_id' => 'required|exists:roles,id'
        ];
    }
}
