@if ($funding_target && $user->role == 2)
  <div class="card col-md-10 offset-md-1 target-wheel">
    <h4>Target: {{ $funding_target == false ? "No funding target created." : "$$funding_target->amount" }} | Earned: ${{$funding_target->amount_gained}}</h4>
    <div class="container">
      <div class="box">
      <div class="chart" data-percent="{{ (($funding_target->amount_gained/$funding_target->amount) * 100) }}">{{ floor(($funding_target->amount_gained/$funding_target->amount) * 100)  }}%</div>
      </div>
    </div>
  </div>
@endif