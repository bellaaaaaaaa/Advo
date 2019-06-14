@extends('layouts.admin.master')
<style>
  .row {
    padding: 15px;
  }
</style>
@section('content')
  <div class="card col-sm-8">
    <img src="{{ $post->cover_image }}" alt="" style="height: 300px !important">
    <div class="row">
      <i class="fa fa-thumbs-up" aria-hidden="true"></i><p>{{ count($post->scholar_post_likes()->get()) }}</p>
      <i class="fa fa-comments-o" aria-hidden="true" style="margin-left: 10px"></i>{{ count($post->scholar_post_comments()->get()) }}
    </div>
    <div class="row">
      <h2>{{ $post->title }}</h2>
    </div>
    <div class="row">
      <p>{{ $post->body }}</p>
    </div>
  </div>
  <div class="card col-sm-8">
      <div class="row">
        <h4>Comments</h4>
      </div>
      <div class="row">
        <table class="table">
          @foreach ($post->scholar_post_comments()->get() as $comment)
            <tr>
              <td class="text-left"><a href="{{ route('users.show', $comment->user_id) }}">User ID: {{ $comment->user_id }}</a></td>
              <td class="text-right">{{ $comment->body }}</td>
            </tr>
          @endforeach
        </table>
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
