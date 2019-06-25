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
  <div style="padding:20px">
    <h2>Update User: {{$user->id}}</h2>
    <hr>
  <update-user-component  :user-id="{{ $user->id }}" :user="{{ $user }}" :user-badges="{{ $user->badges }}" :report-cards="{{ $user->report_cards }}"></update-user-component>
  </div>
@endsection
@section('scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
{!! HTML::script('js/parsley.min.js')!!}
{!! HTML::script('js/select2.min.js')!!}
{{-- <script src="{{ asset('js/intlTelInput.js')}}"></script> --}}
<script>
  // var user = <?php echo json_encode($user); ?>;
  // var roles = {'0' :'Admin', '1' : 'Benefactor', '2' : 'Scholar'};
  // var input = document.querySelector("#phone");
  // window.intlTelInput(input);
</script>
@endsection
