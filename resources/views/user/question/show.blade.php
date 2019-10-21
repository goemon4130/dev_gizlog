@extends ('common.user')
@section ('content')

<h1 class="brand-header">質問詳細</h1>
<div class="main-wrap">
  <div class="panel panel-success">
    <div class="panel-heading">
      <img src="{{ $showQuestion->user->avatar }}" class="avatar-img">
      <p>{{ $showQuestion->user->name }}&nbsp;さんの質問&nbsp;&nbsp;(&nbsp;{{ $showQuestion->created_at->format('Y-m-d H-i') }}&nbsp;)</p>
      <p class="question-date"></p>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <tbody>
          <tr>
            <th class="table-column">Title</th>
            <td class="td-text">{{ $showQuestion->title }}</td>
          </tr>
          <tr>
            <th class="table-column">Question</th>
            <td class='td-text'>{!! nl2br(e($showQuestion->content)) !!}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
    <div class="comment-list">
      @foreach ($questionComments as $questionComment)
        <div class="comment-wrap">
          <div class="comment-title">
            <img src="{{ $questionComment->user->avatar }}" class="avatar-img">
            <p>{{ $questionComment->user->name }}</p>
            <p class="comment-date">{{ $questionComment->created_at->format('Y-m-d H-i') }}</p>
          </div>
          <div class="comment-body">{!! nl2br(e($questionComment->comment)) !!}</div>
        </div>
      @endforeach
    </div>
  <div class="comment-box">
    {!! Form::open(['route' => 'QuestionController.comment']) !!}
      {!! Form::input('hidden', 'question_id', $showQuestion->id) !!}
      <div class="comment-title">
        <img src="" class="avatar-img"><p>コメントを投稿する</p>
      </div>
      <div class="comment-body{{ $errors->has('comment') ? ' has-error' : '' }}">
        {!! Form::textarea('comment', null, ['class' => 'form-control', 'placeholder' => 'Add your comment...']) !!}
        <span class="help-block">{{ $errors->first('comment') }}</span>
      </div>
      <div class="comment-bottom">
        {!! Form::button('<i class="fa fa-pencil" aria-hidden="true"></i>', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
      </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection
