@extends('layouts.admin.master')
{!! Html::style('css/intlTelInput.css') !!}
{!! Html::style('css/parsley.css') !!}
{!! Html::style('css/select2.min.css') !!}
<style>
  .input-margin{
    margin: 2px 0px 15px;
  }
</style>
@section('content')
<div class="row">
  <div class="card col-md-8 offset-md-2" style="padding:20px">
    <h2>Update Scholar Post: {{$post->id}}</h2>
    <hr>
    {!! Form::model($post, ['route' => ['scholar_posts.update', $post->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
        {{ Form::label('title', 'Title:')}}
        {{ Form::text('title', null, array('class' => 'form-control input-margin', 'required' => '')) }}

        {{ Form::label('body', 'Body:')}}
        {{ Form::text('body', null, array('class' => 'form-control input-margin', 'required' => '')) }}
      
        {{ Form::label('cover_image', 'Change Image', array('style' => 'margin-top: 10px'))}}
        {{ Form::file('cover_image ', null, array('class' => 'form-control input-margin')) }}
        <br>
        <label for="">Current Image</label>
        <br>
        <img class="col-sm-4" src="{{ $post->cover_image }}" alt="">
        {{ csrf_field() }}

        {{ Form::submit('Save Changes', array('class' => 'btn-primary btn-lg btn-block', 'style' => 'margin-top: 25px;')) }}
    {{ Form::close() }}
  </div>
</div>
@endsection
@section('scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
{!! HTML::script('js/parsley.min.js')!!}
{!! HTML::script('js/select2.min.js')!!}
<script type="text/javascript">
</script>
@endsection
