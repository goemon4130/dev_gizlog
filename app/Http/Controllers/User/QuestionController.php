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
        $inputRequests = $request->all();
        $questions = $this->question->getQuestion($inputRequests, Auth::id());
        $tagCategories = $this->tagCategory->all();
        return view('user.question.index', compact('questions', 'tagCategories', 'inputRequests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tagCategories = $this->tagCategory->all();
        $tagCategoryCollection = $tagCategories->mapWithKeys(function($item) {
            return [$item['id'] => $item['name']];
        });
        $arrayTagCategory = $tagCategoryCollection->all();
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
        $inputRequests = $request->all();
        $inputRequests['user_id'] = Auth::id();
        $this->question->fill($inputRequests)->save();
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
        $questionComments = $this->comment->getQuestionComments($id);
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
        $tagCategories = $this->tagCategory->all();
        $arrayTagCategory = [];
        foreach ($tagCategories as $tagCategory) {
            $arrayTagCategory += [$tagCategory->id => $tagCategory->name];
        }
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
        $inputRequests = $request->all();
        $this->question->find($id)->fill($inputRequests)->save();
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
        $inputRequests = $request->all();
        $requestTagCategory = $this->tagCategory->find($inputRequests['tag_category_id']);
        return view('user.question.confirm', compact('inputRequests', 'requestTagCategory'));
    }

    public function comment(CommentsRequest $request)
    {
        $inputRequests = $request->all();
        $inputRequests['user_id'] = Auth::id();
        $this->comment->fill($inputRequests)->save();
        return redirect()->route('question.show', $inputRequests['question_id']);
    }

    public function myPage()
    {
        $myPostedQuestions = $this->question->getMyPostedQuestion(Auth::id());
        $myAccount = Auth::user();
        return view('user.question.mypage', compact('myPostedQuestions', 'myAccount'));
    }
}
