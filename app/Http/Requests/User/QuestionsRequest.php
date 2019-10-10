<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class QuestionsRequest extends FormRequest
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
        if ($this->filled('id')) {
            $this->redirect = 'question/'. $this->input('id'). '/edit';
        } else {
            $this->redirect = 'question/create';
        }
        return [
            'select_tag_category_id' => ['sometimes', 'integer', 'nullable'],
            'tag_category_id' => ['sometimes', 'required', 'integer'],
            'title' => ['sometimes', 'required', 'max:255'],
            'content' => ['sometimes', 'required', 'max:2000'],
        ];
    }

    public function messages()
    {
        return [
            'integer' => 'カテゴリーを選んでください',
            'required' => '入力必須です',
            'max' => ':max以下で入力してください',
        ];
    }
}
