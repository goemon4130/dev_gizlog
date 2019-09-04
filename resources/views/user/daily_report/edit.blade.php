@extends ('common.user')
@section ('content')

<h1 class="brand-header">日報編集</h1>
<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => ['dailyreports.update', $dailyReport->id], 'method' => 'PUT']) !!}
      <div class="form-group form-size-small{{ $errors->has('reporting_time') ? ' has-error' : '' }}">
        {!! Form::input('date', 'reporting_time', null, ['class' => 'form-control']) !!}
        @if ($errors->has('reporting_time'))
          <span class="help-block">
            {{ $errors->first('reporting_time') }}
          </span>
        @endif
      </div>
      <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        {!! Form::input('text', 'title', $dailyReport->title, ['class' => 'form-control', 'placeholder' => 'Title']) !!}
        @if ($errors->has('title'))
          <span class="help-block">
            {{ $errors->first('title') }}
          </span>
        @endif
      </div>
      <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
        {!! Form::textarea('content', '本文', ['class' => 'form-control', 'placeholder' => '本文']) !!}
        @if ($errors->has('content'))
          <span class="help-block">
            {{ $errors->first('content') }}
          </span>
        @endif
      </div>
      {!! Form::button('Update', ['class' => 'btn btn-success pull-right', 'type' => 'submit']) !!}
    {!! Form::close() !!}
  </div>
</div>

@endsection
