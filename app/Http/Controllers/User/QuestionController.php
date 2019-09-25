<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\TagCategory;
use App\Models\Comment;
use App\Models\User;
use App\Http\Requests\User\QuestionsRequest;
use Auth;

class QuestionController extends Controller
{
    protected $question;

    protected $tagCategory;

    protected $comment;

    protected $user;

    public function __construct(Question $question, TagCategory $tagCategory, Comment $comment, User $user)
    {
        $this->middleware('auth');
        $this->question = $question;
        $this->tagCategory = $tagCategory;
        $this->comment = $comment;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(QuestionsRequest $request)
    {
        $inputRequests = $request->all();
        if ($inputRequests === [] or $inputRequests['tag_category_id'] === '0') {
            $questions = $this->question->getAllQuestion(Auth::id());
        } elseif (isset($inputRequests['search_word'])) {
            $questions = $this->question->getQuestionByInputWord($inputRequests['search_word']);
        } else {
            $questions = $this->question->getQuestionByCategory($inputRequests['tag_category_id']);
        }
        $tagCategorys = $this->tagCategory->all();
        return view('user.question.index', compact('questions', 'tagCategorys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tagCategorys = $this->tagCategory->all();
        return view('user.question.create', compact('tagCategorys'));
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
        $tagCategorys = $this->tagCategory->all();
        return view('user.question.edit', compact('editQuestion', 'tagCategorys'));
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

    public function comment(QuestionsRequest $request)
    {
        $inputRequests = $request->all();
        $inputRequests['user_id'] = Auth::id();
        $this->comment->fill($inputRequests)->save();
        return redirect()->route('question.show', $inputRequests['question_id']);
    }

    public function myPage()
    {
        $myPostedQuestions = $this->question->getMyPostedQuestions(Auth::id());
        $myAccount = $this->user->find(Auth::id());
        return view('user.question.mypage', compact('myPostedQuestions', 'myAccount'));
    }
}
