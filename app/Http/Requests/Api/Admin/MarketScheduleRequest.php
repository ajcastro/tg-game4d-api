<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * @method \App\Models\User user()
 */
class MarketScheduleRequest extends FormRequest
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
            'result_day' => [
                'array',
            ],
            'close_time' => [
                'required',
                'date_format:H:i',
            ],
            'result_time' => [
                'required',
                'date_format:H:i',
            ],
        ];
    }

    protected function prepareForValidation()
    {
        $close_time = $this->input('close_time');
        $result_time = $this->input('result_time');

        $this->merge([
            'close_time' => substr($close_time, 0, 5),
            'result_time' => substr($result_time, 0, 5),
        ]);
    }
}
