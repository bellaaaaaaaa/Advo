@extends('layouts.admin.master')
@section('content')
  <div style="padding:20px">
    <h2>Update Benefactor: {{$benefactor->id}}</h2>
    <hr>
  <update-benefactor-component :benefactor="{{ $benefactor }}" :user="{{ $user }}" :experiences="{{ $benefactor->experiences }}"></update-benefactor-component>
  </div>
@endsection
@section('scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
@endsection
