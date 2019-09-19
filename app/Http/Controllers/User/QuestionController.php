<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\TagCategory;
use Auth;

class QuestionController extends Controller
{
    protected $question;

    protected $user;

    public function __construct(Question $question, TagCategory $tagCategory)
    {
        $this->middleware('auth');
        $this->question = $question;
        $this->tagCategory = $tagCategory;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allRequest = $request->all();
        if ($allRequest === [] or $allRequest['tag_category_id'] === '0'){
            $questions = $this->question->getAllQuestion(Auth::id());
        } elseif (isset($allRequest['search_word'])){
            $questions = $this->question->getQuestionByMonth($allRequest['search_word']);
        } else {
            $questions = $this->question->getQuestionByCategory($allRequest['tag_category_id']);
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
    public function store(Request $request)
    {
        $allRequest = $request->all();
        $this->question->fill($allRequest)->save();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function confirm(Request $request)
    {
        $allRequest = $request->all();
        $allRequest['user_id'] = Auth::id();
        $requestTagCategory = $this->tagCategory->find($allRequest['tag_category_id']);
        return view('user.question.confirm', compact('allRequest', 'requestTagCategory'));
    }
}
