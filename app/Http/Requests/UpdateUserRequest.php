<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $user = $this->route('user');

        return [
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:100|unique:users,username,' . $user->id,
            'email'=> 'required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string',
            'image' => 'sometimes|mimes:jpeg,jpg,png,gif|max:10000',
            'role_id' => 'required|exists:roles,id'
        ];
    }
}
