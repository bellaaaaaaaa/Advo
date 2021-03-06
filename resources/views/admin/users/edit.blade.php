@extends('layouts.admin.master')
<style>
  .input-margin{
    margin: 2px 0px 15px;
  }
</style>
@section('content')
  <div style="padding:20px">
    <h2>Update User: {{$user->id}}</h2>
    <hr>
  <update-user-component  :funding-target="{{ $fundingTarget }}":user-id="{{ $user->id }}" :user="{{ $user }}" :user-badges="{{ $user->badges }}" :report-cards="{{ $user->report_cards }}"></update-user-component>
  </div>
@endsection
@section('scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
@endsection
