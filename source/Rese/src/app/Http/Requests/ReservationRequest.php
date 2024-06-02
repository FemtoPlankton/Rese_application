<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // 認証や権限のチェックを行うロジックをここに記述
        return true; // 今回はシンプルにtrueを返す例を示していますが、実際のプロジェクトでは適切なロジックを実装してください
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'date|after_or_equal:tomorrow',
            'number' => 'integer|min:1',
            // 他のバリデーションルールをここに追加
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
        'date.date' => '日付は有効な日付形式である必要があります。',
        'date.after_or_equal' => '日付は明日以降を選択してください。',
        'number.integer' => '人数は整数で入力してください。',
        'number.min' => '人数は1以上で入力してください。',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $this->session()->flash('error', '入力内容にエラーがあります。');
        throw new HttpResponseException(
            redirect()->back()->withErrors($validator)->withInput()
        );
    }
}
