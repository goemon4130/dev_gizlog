@extends ('common.user')
@section ('content')

<h1 class="brand-header">日報編集</h1>
<div class="main-wrap">
  <div class="container">
    <!--<form>-->
    {!! Form::open(['route' => ['dailyreports.update', $dailyReport->id], 'method' => 'PUT']) !!}
      <!--<input class="form-control" name="user_id" type="hidden" value="4">-->
      {!! Form::input('hidden', 'user_id', '4', ['class' => 'form-control']) !!}
      <div class="form-group form-size-small">
        <input class="form-control{{ $errors->has('reporting_time') ? ' is-invalid' : '' }}" name="reporting_time" type="date">
        <!--{!! Form::input('date', 'reporting_time', $dailyReport->reporting_time->format('Y-m-d'), ['class' => 'form-control']) !!}-->
      @if ($errors->has('reporting_time'))
        <span class="help-block">
          {{ $errors->first('reporting_time') }}
        </span>
      @endif
      </div>
      <div class="form-group">
        <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="Title" name="title" type="text">
        <!--{!! Form::input('text', 'title', $dailyReport->title, ['class' => 'form-control', 'placeholder' =>'Title']) !!}-->
      @if ($errors->has('title'))
        <span class="help-block">
          {{ $errors->first('title') }}
        </span>
      @endif
      </div>
      <div class="form-group">
        <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" placeholder="本文" name="content" cols="50" rows="10">本文</textarea>
        <!--{!! Form::textarea('content', $dailyReport->content, ['class' => 'form-control', 'placeholder' => '本文']) !!}-->
      @if ($errors->has('content'))
        <span class="help-block">
          {{ $errors->first('content') }}
        </span>
      @endif
      </div>
      <!--<button type="submit" class="btn btn-success pull-right">Update</button>-->
      {!! Form::submit('Update', ['class' => 'btn btn-success pull-right']) !!}
    {!! Form::close() !!}
    <!--</form>-->
  </div>
</div>

@endsection
