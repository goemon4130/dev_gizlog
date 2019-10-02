@extends ('common.user')
@section ('content')

<h1 class="brand-header">質問編集</h1>

<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => 'question.confirm', 'method' => 'GET']) !!}
      <div class="form-group{{ $errors->has('tag_category_id') ? ' has-error' : '' }}">
        <select name='tag_category_id' class = "form-control selectpicker form-size-small" id ="pref_id">
          <option value="{{ $editQuestion->tagCategory->id }}">{{ $editQuestion->tagCategory->name }}</option>
          @foreach($tagCategories as $tagCategory)
            <option value= "{{ $tagCategory->id }}">{{ $tagCategory->name }}</option>
          @endforeach
        </select>
        <span class="help-block">{{ $errors->first('tag_category_id') }}</span>
      </div>
      <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        {!! Form::input('text', 'title', $editQuestion->title, ['class' => 'form-control', 'placeholder' => 'title']) !!}
        <span class="help-block">{{ $errors->first('title') }}</span>
      </div>
      <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
        {!! Form::textarea('content', $editQuestion->content, ['class' => 'form-control', 'placeholder' => 'Please write down your question here...']) !!}
        <span class="help-block">{{ $errors->first('content') }}</span>
      </div>
      {!! Form::input('submit', 'confirm', 'update', ['class' => 'btn btn-successs pull-right']) !!}
      {!! Form::input('hidden', 'id', $editQuestion->id) !!}
    {!! Form::close() !!}
  </div>
</div>

@endsection
