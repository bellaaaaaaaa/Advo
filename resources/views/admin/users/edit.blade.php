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
    <h2>Update User: {{$user->id}}</h2>
    <hr>
    {!! Form::model($user, ['route' => ['users.update', $user->id], 'data-parsley-validate' => '', 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
        {{ Form::label('name', 'Name:')}}
        {{ Form::text('name', null, array('class' => 'form-control input-margin', 'required' => '', 'maxlength' => '255')) }}

        {{ Form::label('email', 'Email:')}}
        {{ Form::email('email', null, array('class' => 'form-control input-margin', 'required' => '', 'maxlength' => '255')) }}

        {{ Form::label('role', 'Role:')}}
        {{ Form::select('role', $roles, $user->role, ['class' => 'form-control input-margin']) }}

        {{ Form::label('date_of_birth', 'Date of Birth:')}}
        {{ Form::date('date_of_birth', null, array('class' => 'form-control input-margin', 'required' => '', 'maxlength' => '255')) }}

        {{ Form::label('phone_number', 'Phone number:')}}
        <br>
        {{ Form::tel('phone_number', null, array('id' => 'phone', 'class' => 'form-control input-margin', 'required' => '')) }}
        <br>

        {{ Form::label('ic_passport_number', 'IC / Passport Number:', array('style' => 'margin-top: 10px'))}}
        {{ Form::text('ic_passport_number', null, array('class' => 'form-control input-margin', 'required' => '', 'maxlength' => '255')) }}

        {{ Form::label('bio', 'Bio:')}}
        {{ Form::text('bio', null, array('class' => 'form-control input-margin', 'required' => '', 'maxlength' => '255')) }}

        {{ Form::label('badges', 'Badges:') }}
        {{ Form::select('badges[]', $badges, null, ['class' => 'form-control select2-multi', 'multiple' => 'multiple']) }}

        {{ Form::label('interests', 'Interests:') }}
        {{ Form::select('interests[]', $interests, null, ['class' => 'form-control select2-multi', 'multiple' => 'multiple']) }}

        {{ Form::label('avatar', 'Avatar', array('style' => 'margin-top: 10px'))}}
        {{ Form::file('avatar', null, array('class' => 'form-control input-margin', 'maxlength' => '255')) }}
        {{ csrf_field() }}

        {{ Form::submit('Save Changes', array('class' => 'btn-primary btn-lg btn-block', 'style' => 'margin-top: 25px;')) }}
    {{ Form::close() }}
  </div>
</div>
@endsection
@section('scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
{!! HTML::script('js/parsley.min.js')!!}
{!! HTML::script('js/parsley.min.js')!!}
{!! HTML::script('js/select2.min.js')!!}
<script type="text/javascript">
    $('.select2-multi').select2();
</script>
<script src="{{ asset('js/intlTelInput.js')}}"></script>
<script>
  var user = <?php echo json_encode($user); ?>;
  var roles = {'0' :'Admin', '1' : 'Benefactor', '2' : 'Scholar'};
  
  // $(document).ready(function({
  //   $('#role').val(roles[user.role]);
  // }));
  var input = document.querySelector("#phone");
  window.intlTelInput(input);
</script>
@endsection
