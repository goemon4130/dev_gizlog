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
            'select_tag_category_id' => ['sometimes', 'integer', 'exists:tag_categories,id', 'nullable'],
            'tag_category_id' => ['sometimes', 'required', 'integer'],
            'title' => ['sometimes', 'required', 'max:255'],
            'content' => ['sometimes', 'required', 'max:2000'],
        ];
    }

    public function messages()
    {
        return [
            'integer' => '数字にしてください',
            'required' => '入力必須です',
            'max' => ':max以下で入力してください',
            'exists' => 'その数字は存在しません',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if (($this->url() === route('QuestionController.store') and $this->isMethod('post')) ||    
        ($this->url() === route('QuestionController.update', ['id' => $this->input('id')]) and $this->isMethod('put'))) {
            $this->redirectRoute = 'QuestionController.index';
            session()->flash('system_error', '不正な操作です。');
        }
        throw (new ValidationException($validator))
                    ->errorBag($this->errorBag)
                    ->redirectTo($this->getRedirectUrl());
    }
}
