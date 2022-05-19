<?php

namespace App\Http\Requests\Api\Gamesite;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * @method \App\Models\User user()
 */
class GameTransactionStoreRequest extends FormRequest
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
            'game_id' => [
                'required',
                'exists:games,id'
            ],
            'rows.*.gameSetting' => [
                'required',
            ],
            'rows.*.game_code' => [
                'required',
            ],
            'rows.*.bet' => [
                'required',
            ],
        ];
    }
}
