@extends('layouts.admin.master')
@section('content')
  <div class="row">
    <div class="card col-md-8 offset-md-2" style="padding:20px">
      <h2>Create Post</h2>
      <hr>
      {{ Form::open(['route' => 'scholar_posts.store', 'files' => true]) }}
          {{ Form::hidden('user_id', $user->id) }}
          {{ Form::label('title', 'Title:')}}
          {{ Form::text('title', null, array('class' => 'form-control', 'required' => '', 'maxlength' => '255')) }}

          {{ Form::label('body', 'Body:')}}
          {{ Form::textarea('body', null, array('class' => 'form-control', 'required' => '')) }}
          <br>
          {{ Form::label('cover_image', 'Cover Image:')}}
          {{ Form::file('cover_image', null, array('class' => 'form-control', 'required' => '')) }}

          {{ Form::submit('Create', array('class' => 'btn-primary btn-lg btn-block', 'style' => 'margin-top: 25px;')) }}
      {{ Form::close() }}
    </div>
  </div>
@endsection

@section('scripts')
  {{-- {!! HTML::script('js/parsley.min.js')!!} --}}
  <script type="text/javascript">
    function operateFormatter(value, row, index) {
      return [
				'<a rel="tooltip" title="Remove" class="btn btn-link btn-danger table-action remove" href="javascript:void(0)">',
        '<i class="fa fa-remove"></i>',
        '</a>'
      ].join('');
    }
  </script>
@endsection
