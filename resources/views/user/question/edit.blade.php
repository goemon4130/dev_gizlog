@extends ('common.user')
@section ('content')

<h1 class="brand-header">質問編集</h1>

<div class="main-wrap">
  <div class="container">
    <!--<form>-->
    {!! Form::open(['route' => 'question.confirm']) !!}
      <div class="form-group">
        <select name='tag_category_id' class = "form-control selectpicker form-size-small" id ="pref_id">
          <option value="{{ $editQuestion->tagCategory->id }}">{{ $editQuestion->tagCategory->name }}</option>
          @foreach($tagCategorys as $tagCategory)
            <option value= "{{ $tagCategory->id }}">{{ $tagCategory->name }}</option>
          @endforeach
        </select>
        <span class="help-block"></span>
      </div>
      <div class="form-group">
        <!--<input class="form-control" placeholder="title" name="title" type="text" value="">-->
        {!! Form::input('text', 'title', $editQuestion->title, ['class' => 'form-control', 'placeholder' => 'title']) !!}
        <span class="help-block"></span>
      </div>
      <div class="form-group">
        <!--<textarea class="form-control" placeholder="Please write down your question here..." name="content" cols="50" rows="10"></textarea>-->
        {!! Form::textarea('content', $editQuestion->content, ['class' => 'form-control', 'placeholder' => 'Please write down your question here...']) !!}
        <span class="help-block"></span>
      </div>
      <!--<input name="confirm" class="btn btn-success pull-right" type="submit" value="update">-->
      {!! Form::input('submit', 'confirm', 'update', ['class' => 'btn btn-successs pull-right']) !!}
      {!! Form::input('hidden', 'id', $editQuestion->id) !!}
    <!--</form>-->
    {!! Form::close() !!}
  </div>
</div>

@endsection
