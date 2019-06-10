@extends('layouts.admin.master')
{!! Html::style('css/intlTelInput.css') !!}
{!! Html::style('css/parsley.css') !!}
<style>
  .input-margin{
    margin: 2px 0px 15px;
  }
</style>
@section('content')
<div class="row">
  <div class="card col-md-8 offset-md-2" style="padding:20px">
    <h3>Update Interest: {{$interest->id}}</h3>
    <hr>
    {!! Form::model($interest, ['route' => ['interests.update', $interest->id], 'data-parsley-validate' => '', 'method' => 'PUT']) !!}
        {{ Form::label('title', 'Title:')}}
        {{ Form::text('title', null, array('class' => 'form-control input-margin', 'required' => '', 'maxlength' => '255')) }}

        {{ Form::submit('Save Changes', array('class' => 'btn-primary btn-lg btn-block', 'style' => 'margin-top: 25px;')) }}
    {{ Form::close() }}
  </div>
</div>
@endsection
@section('scripts')
{!! HTML::script('js/parsley.min.js')!!}
@endsection
