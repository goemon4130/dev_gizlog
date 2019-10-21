@extends ('common.user')
@section ('content')

<h2 class="brand-header">質問一覧</h2>
<div class="main-wrap">
  {!! Form::open(['route' => 'QuestionController.index', 'method' => 'GET', 'class' => 'form']) !!}
    <div class="btn-wrapper">
      <div class="search-box">
        {!! Form::input('text', 'search_word', isset($inputs['search_word']) ? $inputs['search_word'] : null, ['class' => 'form-control search-form', 'placeholder' => 'Search words']) !!}
        {!! Form::button('<i class="fa fa-search" aria-hidden="true"></i>', ['class' => 'search-icon', 'type' => 'submit']) !!}
      </div>
      <a class="btn" href="{{ route('QuestionController.create') }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
      <a class="btn" href="{{ route('QuestionController.mypage') }}">
        <i class="fa fa-user" aria-hidden="true"></i>
      </a>
      <div class="{{ $errors->has('select_tag_category_id') ? ' has-error' : '' }}">
        <span class="help-block">{{ $errors->first('select_tag_category_id') }}</span>
      </div>
      <div class="{{ session('system_error') ? ' has-error' : '' }}">
        <span class="help-block">{{ session('system_error') }}</span>
      </div>
    </div>
    <div class="category-wrap">
      <div class="btn all" id="0">all</div>
      @foreach ($tagCategories as $tagCategory)
        <div class="btn {{ $tagCategory->name }}" id="{{ $tagCategory->id}}">{{ $tagCategory->name}}</div>
      @endforeach
      {!! Form::input('hidden', 'select_tag_category_id', null, ['id' => 'category-val']) !!}
    </div>
  {!! Form::close() !!}
  <div class="content-wrapper table-responsive">
    <table class="table table-striped">
      <thead>
        <tr class="row">
          <th class="col-xs-1">user</th>
          <th class="col-xs-2">category</th>
          <th class="col-xs-6">title</th>
          <th class="col-xs-1">comments</th>
          <th class="col-xs-2"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($questions as $question)
        <tr class="row">
          <td class="col-xs-1"><img src="{{ $question->user->avatar }}" class="avatar-img"></td>
          <td class="col-xs-2">{{ $question->tagCategory->name }}</td>
          <td class="col-xs-6">{{ str_limit($question->title, $limit = 30, $end = '...') }}</td>
          <td class="col-xs-1"><span class="point-color">{{ $question->comments->count() }}</span></td>
          <td class="col-xs-2">
            <a class="btn btn-success" href="{{ route('QuestionController.show', $question->id) }}">
              <i class="fa fa-comments-o" aria-hidden="true"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div aria-label="Page navigation example" class="text-center"></div>
  </div>
</div>

@endsection
