<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * @method \App\Models\User user()
 */
class GameRequest extends FormRequest
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
        $game = $this->route('game');

        return sometimes_if($game, [
            'date' => [
                'required',
                'date',
            ],
            'close_time' => [
                'required',
                'date_format:H:i',
            ],
            'result_time' => [
                'required',
                'date_format:H:i',
            ],
            'market_result' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (strlen($value) != 4) {
                        $fail('The :attribute must be 4 digits.');
                    }
                },
            ],
        ]);
    }
}
