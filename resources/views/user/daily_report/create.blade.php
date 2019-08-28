@extends ('common.user')
@section ('content')

<h2 class="brand-header">日報作成</h2>
<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => 'dailyreports.store']) !!}
      <input class="form-control" name="user_id" type="hidden">
      <div class="form-group form-size-small">
        <input class="form-control{{ $errors->has('reporting_time') ? ' is-invalid' : '' }}" name="reporting_time" type="date">
        @if ($errors->has('reporting_time'))
          <span class="help-block">
            {{ $errors->first('reporting_time') }}
          </span>
        @endif
      </div>
      <div class="form-group">
        <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="Title" name="title" type="text">
        @if ($errors->has('title'))
          <span class="help-block">
            {{ $errors->first('title') }}
          </span>
        @endif
      </div>
      <div class="form-group">
        <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" placeholder="Content" name="content" cols="50" rows="10"></textarea>
        @if ($errors->has('content'))
          <span class="help-block">
            {{ $errors->first('content') }}
          </span>
        @endif
      </div>
      <button type="submit" class="btn btn-success pull-right">Add</button>
    {!! Form::close() !!}
  </div>
</div>

@endsection
