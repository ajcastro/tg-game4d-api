<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * @method \App\Models\User user()
 */
class UserRequest extends FormRequest
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
        $user = $this->route('user');

        return sometimes_if($user, [
            'name' => [
                'required',
                'string',
            ],
            'username' => [
                'required',
                'string',
                Rule::unique('users', 'username')->ignore($user),
            ],
            'email' => [
                'required',
                'string',
                'email',
            ],
            'password' => Rule::when(is_null($user), [
                'required',
                Password::min(8),
                'confirmed'
            ])
        ]);
    }
}
