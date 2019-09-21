@extends ('common.user')
@section ('content')

<h2 class="brand-header">
  <img src="{{ $myAccount->avatar }}" class="avatar-img">&nbsp;&nbsp;My page
</h2>
<div class="main-wrap">
  <div class="content-wrapper table-responsive">
    <table class="table table-striped">
      <thead>
        <tr class="row">
          <th class="col-xs-2">date</th>
          <th class="col-xs-1">category</th>
          <th class="col-xs-5">title</th>
          <th class="col-xs-2">comments</th>
          <th class="col-xs-1"></th>
          <th class="col-xs-1"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($myPostedQuestions as $myPostedQuestion)
          <tr class="row">
            <td class="col-xs-2">{{ $myPostedQuestion->created_at }}</td>
            <td class="col-xs-1">{{ $myPostedQuestion->tagCategory->name }}</td>
            <td class="col-xs-5">{{ $myPostedQuestion->title }}</td>
            <td class="col-xs-2"><span class="point-color">{{ $myPostedQuestion->comments->count() }}</span></td>
            <td class="col-xs-1">
              <a class="btn btn-success" href="{{ route('question.edit', $myPostedQuestion->id) }}">
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </a>
            </td>
            <td class="col-xs-1">
              <!--<form>
                <button class="btn btn-danger" type="submit">
                  <i class="fa fa-trash-o" aria-hidden="true"></i>
                </button>
            </form>-->
              {!! Form::open(['route' => ['question.destroy', $myPostedQuestion->id], 'method' => 'DELETE']) !!}
                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
              {!! Form::close() !!}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection
