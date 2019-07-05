@extends('layouts.admin.master')
<style>
  .input-margin{
    margin: 2px 0px 15px;
  }
</style>
@section('content')
  <div style="padding:20px">
    <h2>Update Scholar: {{$scholar->id}}</h2>
    <hr>
  <update-user-component :schools="{{ $schools }}" :school="{{ $scholar->school }}" :scholar="{{ $scholar }}" :funding-target="{{ $funding_target ? $funding_target : 'null' }}" :report-cards="{{ $scholar->report_cards }}" :posts="{{ $scholar->scholar_posts }}"></update-user-component>
  </div>
@endsection
@section('scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
@endsection
