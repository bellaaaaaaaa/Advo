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
<div class="col-md-10 offset-md-1">
  <div class="row">
    <h4 style="margin: 0">Posts</h4>
    <a href="{{ route('scholar_posts.create', $user->id) }}">
      <i class="fa fa-plus-circle" aria-hidden="true" style="width: 40px; font-size: 25px"></i>
    </a>
  </div>
  <div class="row">
    <table class="table">
    @foreach ($user->scholar_posts()->get() as $post)
      <tr>
        <td class="text-left">{{ $post->title }}</td> 
        <td class="text-right">
          <a href="{{ route('scholar_posts.show', $post->id) }}" class="btn btn-info" style="color: white">View</a>
          {!! Form::open(['route' => ['scholar_posts.destroy', $post->id], 'method' => 'DELETE'])!!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block', 'style' => 'width: 67px; float: right']) !!}
          {!! Form::close() !!}
        </td>
      </tr>
      @endforeach
    </table>
  </div>
</div>