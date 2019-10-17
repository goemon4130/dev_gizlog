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
    protected $question;

    protected $tagCategory;

    protected $comment;

    public function __construct(Question $question, TagCategory $tagCategory, Comment $comment)
    {
        $this->middleware('auth');
        $this->question = $question;
        $this->tagCategory = $tagCategory;
        $this->comment = $comment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(QuestionsRequest $request)
    {
        $inputs = $request->all();
        $questions = $this->question->getQuestion(Auth::id(), $inputs);
        $tagCategories = $this->tagCategory->all();
        return view('user.question.index', compact('questions', 'tagCategories', 'inputs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrayTagCategory = $this->getArrayTagCategory();
        return view('user.question.create', compact('arrayTagCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionsRequest $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = Auth::id();
        $this->question->fill($inputs)->save();
        return redirect()->route('question.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $showQuestion = $this->question->find($id);
        $questionComments = $showQuestion->comments()->with('user')->get();
        return view('user.question.show', compact('showQuestion', 'questionComments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editQuestion = $this->question->find($id);
        $arrayTagCategory = $this->getArrayTagCategory();
        return view('user.question.edit', compact('editQuestion', 'arrayTagCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionsRequest $request, $id)
    {
        $inputs = $request->all();
        $this->question->find($id)->fill($inputs)->save();
        return redirect()->route('question.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->question->find($id)->delete();
        $this->comment->where('question_id', $id)->delete();
        return redirect()->route('question.mypage');
    }

    public function confirm(QuestionsRequest $request)
    {
        $inputs = $request->all();
        $requestTagCategory = $this->tagCategory->find($inputs['tag_category_id']);
        return view('user.question.confirm', compact('inputs', 'requestTagCategory'));
    }

    public function comment(CommentsRequest $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = Auth::id();
        $this->comment->fill($inputs)->save();
        return redirect()->route('question.show', $inputs['question_id']);
    }

    public function myPage()
    {
        $myPostedQuestions = $this->question->getQuestion(Auth::id());
        $myAccount = Auth::user();
        return view('user.question.mypage', compact('myPostedQuestions', 'myAccount'));
    }

    private function getArrayTagCategory()
    {
        $tagCategories = $this->tagCategory->all();
        $tagCategoryCollection = $tagCategories->mapWithKeys(function($item) {
            return [$item['id'] => $item['name']];
        });
        $arrayTagCategory = $tagCategoryCollection->all();
        return $arrayTagCategory;
    }
}
