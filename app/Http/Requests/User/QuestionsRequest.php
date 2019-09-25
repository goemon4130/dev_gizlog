<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class QuestionsRequest extends FormRequest
{
    protected $redirect;

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
        if (isset($inputWord['search_word'])) {
            return [];
        } elseif (array_key_exists('tag_category_id', $inputWord) and array_key_exists('search_word', $inputWord)) {
            return [
                'tag_category_id' => ['sometimes', 'nullable', 'integer'],
            ];
        }

        if (isset($inputWord['id'])) {
            $this->redirect = 'question/'. $inputWord['id']. '/edit';
        } elseif (empty($inputWord['id']) and array_key_exists('title', $inputWord) and array_key_exists('content', $inputWord)) {
            $this->redirectRoute = 'question.create';
        }
        return [
            'tag_category_id' => ['sometimes', 'required', 'integer'],
            'title' => ['sometimes', 'required', 'max:255'],
            'content' => ['sometimes', 'required', 'max:2000'],
            'comment' => ['sometimes', 'required', 'max:2000'],
        ];
    }

    public function messages()
    {
        return [
            'tag_category_id.integer' => 'カテゴリーを選んでください',
            'tag_category_id.required' => '入力必須です。',
            'title.required' => '入力必須です。',
            'title.max' => ':max以下で入力してください。',
            'content.required' => '入力必須です。',
            'content.max' => ':max以下で入力してください。',
            'comment.required' => '入力必須です。',
            'comment.max' => ':max以下で入力してください。' ,
        ];
    }
}
