@extends('layouts.admin.master')
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<style>
  .container .box .chart {
    position: relative;
    width: 180px;
    height: 180px;
    margin: 0 auto; 
    text-align: center;
    font-size: 25px;
    font-weight: 300;
    line-height: 180px;
  }
  .container .box canvas {
    position: absolute;
    top: 0;
    left: 0

  }
  .target-wheel {
    background-color: rgb(81, 134, 280);
    background-image: linear-gradient(rgb(81, 134, 280), #ccbaff);
    color: white;
    border: 0 !important;
    padding-bottom: 25px;
    text-align: center;
  }
  p {
    font-weight: 300
  }
  .fa {
    color: rgb(81, 134, 280)
  }
</style>

@section('content')
  <div class="card col-md-10 offset-md-1" style="padding: 20px; border: none; background-color: transparent">
    <div class="row">
      <div class="col-md-3" style="padding-right: 0;">
        <img src="{{ $user->avatar == null ? asset('/images/default-person.png') : $user->avatar }}" alt="" style="width:150px; height: 150px; border-radius: 50%">
      </div>
      <div class="col-md-9" style="background-color: white; border-radius: 6px">
        <h4>
          {{ $user->name }} | {{ $user->role < 1 ? 'Admin' : ($user->role == 1 ? 'Benefactor' : 'Scholar')}}
        </h4>
        <div class="row; display: inline-block">
          <i class="fa fa-info" aria-hidden="true" style="display: inline-block"></i>
          <p style="display: inline-block; font-weight: 300; margin-right: 15px"> {{ $user->bio }}</p>
        </div>
        <div class="info" style='display:inline-block'>
          <i class="fa fa-envelope" aria-hidden='true'></i>
          <p style="display: inline-block; font-weight: 300; margin-right: 15px;">
            {{$user->email}}
          </p>
          <i class="fa fa-phone" aria-hidden="true"></i>
          <p style="display: inline-block; font-weight: 300; margin-right: 15px;">
            {{$user->phone_number}}
          </p>
          <i class="fa fa-birthday-cake" aria-hidden="true"></i>
          <p style="display: inline-block; font-weight: 300; margin-right: 15px;">
            {{$user->date_of_birth}}
          </p>
          <i class="fa fa-id-card-o" aria-hidden="true"></i>
          <p style="display: inline-block; font-weight: 300; margin-right: 15px;">
            {{$user->ic_passport_number}}
          </p>
        </div>
      </div>
    </div>
  </div>
<div>
  <user-interests-component :user-id="{{ $user->id }}"></user-interests-component>
</div>
<div>
  <user-badges-component :user-id="{{ $user->id }}"></user-badges-component>
</div>
<div class="card col-md-10 offset-md-1 target-wheel">
  <h4>Target: {{ $funding_target == false ? "No funding target created." : "$$funding_target->amount" }} | Earned: ${{$funding_target->amount_gained}}</h4>
  <div class="container">
    <div class="box">
    <div class="chart" data-percent="{{ (($funding_target->amount_gained/$funding_target->amount) * 100) }}">{{ floor(($funding_target->amount_gained/$funding_target->amount) * 100)  }}%</div>
    </div>
  </div>
</div>
<div class="card col-md-10 offset-md-1">
  <h4>Report Cards</h4>
  <div class="container">
    <div class="box">
      <report-card-component :user-id="{{ $user->id }}"></report-card-component>
    </div>
  </div>
</div>
@endsection
@section('scripts')
  {{-- <script>
    window.$ = window.jQuery = require('jquery');
  </script>
  <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script> --}}
  <script src="{{ asset('js/jquery.easypiechart.js')}}"></script>
  <script>
    $(function() {
      $('.chart').easyPieChart({
        size: 180,
        barColor: '#4ffcff',
        scaleColor: false,
        lineWidth: 15,
        trackColor: '#373737',
        lineCap: 'circle',
        animate: 2000
      });
    });
    $(document).ready(function (){
      $('#postajax').on('click', function(){
        var formData = $('#formdata').serialize();
        $.ajax({
          type: "POST",
          url: 'admin/report_cards',
          data: formData
        })
        .done(function(data){
          console.log(data);
        })
      })
    })
  </script>
@endsection
