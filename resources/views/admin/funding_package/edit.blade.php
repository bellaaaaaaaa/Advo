@extends('layouts.admin.master')
<style>
  .input-margin{
    margin: 2px 0px 15px;
  }
</style>
@section('content')
<div class="row">
  <div class="card col-md-8 offset-md-2" style="padding:20px">
    <h2>Update Funding Package: {{$fundingPackage->id}}</h2>
    <hr>
    {!! Form::model($fundingPackage, ['route' => ['funding_packages.update', $fundingPackage->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
        {{ Form::label('title', 'Title:')}}
        {{ Form::text('title', null, array('class' => 'form-control input-margin', 'required' => '')) }}

        {{ Form::label('description', 'Description:')}}
        {{ Form::text('description', null, array('class' => 'form-control input-margin', 'required' => '')) }}

        {{ Form::label('body', 'Body:')}}
        {{ Form::text('body', null, array('class' => 'form-control input-margin', 'required' => '')) }}
      
        {{ Form::label('payment_method_type', 'Payment Method Type:', array('style' => 'margin-top: 10px'))}}
        {{ Form::select('payment_method_type ', $options, null, array('class' => 'form-control input-margin')) }}

        {{ Form::submit('Save Changes', array('class' => 'btn-primary btn-lg btn-block', 'style' => 'margin-top: 25px;')) }}
    {{ Form::close() }}
  </div>
</div>
@endsection
@section('scripts')
@endsection
