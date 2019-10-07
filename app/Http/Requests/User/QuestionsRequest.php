<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class QuestionsRequest extends FormRequest
{
    protected $redirectRoute;

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
        $inputWord = $this->all();
        if (isset($inputWord['id'])) {
            $this->redirectRoute = 'question.edit';
        } elseif (array_key_exists('title', $inputWord) and array_key_exists('content', $inputWord)) {
            $this->redirectRoute = 'question.create';
        }
        return [
            'select_tag_category_id' => ['sometimes', 'integer', 'nullable'],
            'tag_category_id' => ['sometimes', 'required', 'integer'],
            'title' => ['sometimes', 'required', 'max:255'],
            'content' => ['sometimes', 'required', 'max:2000'],
            'comment' => ['sometimes', 'required', 'max:2000'],
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

    protected function getRedirectUrl()
    {
        $inputWord = $this->all();
        $url = $this->redirector->getUrlGenerator();

        switch ($this->redirectRoute) {
            case 'question.edit':
                return $url->route($this->redirectRoute, $inputWord['id']);
                break;
            default:
                break;
        }

        if ($this->redirect) {
            return $url->to($this->redirect);
        } elseif ($this->redirectRoute) {
            return $url->route($this->redirectRoute);
        } elseif ($this->redirectAction) {
            return $url->action($this->redirectAction);
        }

        return $url->previous();
    }
}
