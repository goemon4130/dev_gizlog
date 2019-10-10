<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

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

    protected function failedValidation(Validator $validator)
    {
        if ($this->path() === 'question/request/confirm') {
            throw (new ValidationException($validator))
                    ->errorBag($this->errorBag)
                    ->redirectTo($this->getRedirectUrl());
        }
        $this->redirectRoute = 'question.index';
        session()->flash('system_error', '不正な操作です。');
        throw (new ValidationException($validator))
                    ->errorBag($this->errorBag)
                    ->redirectTo($this->getRedirectUrl());
    }
}
