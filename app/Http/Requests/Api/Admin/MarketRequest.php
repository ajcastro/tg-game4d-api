<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * @method \App\Models\User user()
 */
class MarketRequest extends FormRequest
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
        $market = $this->route('market');

        return sometimes_if($market, [
            'code' => [
                Rule::unique('markets')->ignore($market),
                'required',
                'string',
            ],
            'name' => [
                'required',
                'string',
            ],
            'period' => [
                'required',
                'numeric',
            ],
            'website' => [],
            'flag' => [
                'nullable',
                'image',
            ],
        ]);
    }
}
