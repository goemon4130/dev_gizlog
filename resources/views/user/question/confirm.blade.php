@extends ('common.user')
@section ('content')

<h2 class="brand-header">投稿内容確認</h2>
<div class="main-wrap">
  <div class="panel panel-success">
    <div class="panel-heading">
      {{ $requestTagCategory->name }}の質問
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <tbody>
          <tr>
            <th class="table-column">Title</th>
            <td class="td-text">{{ $allRequest['title'] }}</td>
          </tr>
          <tr>
            <th class="table-column">Question</th>
            <td class='td-text'>{{ $allRequest['content'] }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="btn-bottom-wrapper">
    <!--<form>
      <input name="user_id" type="hidden" value="">
      <input name="tag_category_id" type="hidden" value="">
      <input name="title" type="hidden" value="">
      <input name="content" type="hidden" value="">
      <button type="submit" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></button>
  </form>-->
    @if (parse_url(url()->previous())['path'] === '/question/create')
      {!! Form::open(['route' => 'question.store']) !!}
    @else
      {!! Form::open(['route' => ['question.update', $allRequest['id']], 'method' => 'PUT']) !!}
    @endif
    {!! Form::input('hidden', 'tag_category_id', $allRequest['tag_category_id']) !!}
    {!! Form::input('hidden', 'title', $allRequest['title']) !!}
    {!! Form::input('hidden', 'content', $allRequest['content']) !!}
    {!! Form::button('<i class="fa fa-check" aria-hidden="true"></i>', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
  {!! Form::close() !!}
  </div>
</div>

@endsection
