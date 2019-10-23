<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\TagCategory;
use App\Models\Comment;
use App\Http\Requests\User\QuestionsRequest;
use App\Http\Requests\User\CommentsRequest;
use Auth;

class QuestionController extends Controller
{
    private $question;

    private $tagCategory;

    private $comment;

    public function __construct(Question $question, TagCategory $tagCategory, Comment $comment)
    {
        $this->middleware('auth');
        $this->question = $question;
        $this->tagCategory = $tagCategory;
        $this->comment = $comment;
    }

    /**
     * 質問一覧表示
     *
     * @param  \App\Http\Requests\User\QuestionRequest  $request
     * @return \Illuminate\View\View
     */
    public function index(QuestionsRequest $request)
    {
        $inputs = $request->all();
        $questions = $this->question->getQuestion($inputs);
        $tagCategories = $this->tagCategory->all();
        return view('user.question.index', compact('questions', 'tagCategories', 'inputs'));
    }

    /**
     * 新規作成画面表示
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $arrayTagCategory = $this->getArrayTagCategory();
        return view('user.question.create', compact('arrayTagCategory'));
    }

    /**
     * 新規作成処理
     *
     * @param  \App\Http\Requests\User\QuestionRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(QuestionsRequest $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = Auth::id();
        $this->question->fill($inputs)->save();
        return redirect()->route('QuestionController.index');
    }

    /**
     * 質問詳細画面表示
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $showQuestion = $this->question->find($id);
        return view('user.question.show', compact('showQuestion'));
    }

    /**
     * 質問更新画面表示
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $editQuestion = $this->question->find($id);
        $arrayTagCategory = $this->getArrayTagCategory();
        return view('user.question.edit', compact('editQuestion', 'arrayTagCategory'));
    }

    /**
     * 質問更新処理
     *
     * @param  \App\Http\Requests\User\QuestionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuestionsRequest $request, $id)
    {
        $inputs = $request->all();
        $this->question->find($id)->fill($inputs)->save();
        return redirect()->route('QuestionController.index');
    }

    /**
     * 質問と、それに紐づくコメント削除処理
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->question->find($id)->delete();
        $this->comment->where('question_id', $id)->delete();
        return redirect()->route('QuestionController.mypage');
    }

    /**
     * 新規作成、質問更新時の確認画面表示
     * 
     * @param  \App\Http\Requests\User\QuestionRequest  $request
     * @return \Illuminate\View\View
     */
    public function confirm(QuestionsRequest $request)
    {
        $inputs = $request->all();
        $requestTagCategory = $this->tagCategory->find($inputs['tag_category_id']);
        return view('user.question.confirm', compact('inputs', 'requestTagCategory'));
    }

    /**
     * コメント投稿処理
     * 
     * @param \App\Http\Requests\User\CommentsRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment(CommentsRequest $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = Auth::id();
        $this->comment->fill($inputs)->save();
        return redirect()->route('QuestionController.show', $inputs['question_id']);
    }

    /**
     * ログインユーザが投稿した質問一覧表示
     * 
     * @return \Illuminate\View\View
     */
    public function myPage()
    {
        $user = Auth::user();
        $myPostedQuestions = $this->question->getQuestion(array('user_id' => $user->id));
        return view('user.question.mypage', compact('myPostedQuestions', 'user'));
    }

    /**
     * タグカテゴリの配列生成処理
     * 
     * @return Array
     */
    private function getArrayTagCategory()
    {
        return $this->tagCategory->all()->pluck('name', 'id')->all();
    }
}
