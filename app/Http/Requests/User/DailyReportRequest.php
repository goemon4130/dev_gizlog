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
        $inputMonth = $this->all();
        if (empty($inputMonth) or (array_key_exists('search-month', $inputMonth) and $inputMonth['search-month'] === null)) {
            return [];
        } elseif (array_key_exists('reporting_time', $inputMonth) or array_key_exists('title', $inputMonth) or array_key_exists('content', $inputMonth)) {
            return [
                'reporting_time' => ['required', 'date'],
                'title' => ['required', 'max:255'],
                'content' => ['required', 'max:2000'],
            ];
        } else {
            return [
                'search-month' => ['date'],
            ];
        }
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
