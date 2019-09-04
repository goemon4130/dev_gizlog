<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class DailyReportRequest extends FormRequest
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
            'reporting_time' => ['sometimes', 'required', 'date'],
            'title' => ['sometimes', 'required', 'max:255'],
            'content' => ['sometimes', 'required', 'max:2000'],
            'search-month' => ['sometimes', 'date'],
        ];
    }

    public function messages()
    {
        return [
            'reporting_time.required' => '入力必須の項目です。',
            'reporting_time' => '日付で入力してください。',
            'title.required' => '入力必須の項目です。',
            'title.max' => '255文字以下で入力してください。',
            'content.required' => '入力必須の項目です。',
            'content.max' => '2000文字以下で入力してください。',
            'search-month.date' => '日付で検索してください。'
        ];
    }
}
