<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
<style>
  #bar-chart{
    font-family: Lato, Helvetica-Neue, monospace;
  }

  .ct-series-a .ct-bar {
    /* Colour of your bars */
    stroke:  #be1e2d;
    stroke-width: 15;
  }
  .ct-series-b .ct-bar {
    /* Colour of your bars */
    stroke:  #00a79d;
    stroke-width: 15;
  }
  svg.ct-chart-bar, svg.ct-chart-line{
	  overflow: visible;
  }
.ct-label.ct-label.ct-horizontal.ct-end {
  position: relative;
  justify-content: flex-end;
  text-align: right;
  transform-origin: 100% 0;
  transform: translate(-100%) rotate(-90deg);
  white-space:nowrap;
  font-size: 12px !important
}

}
</style>
@extends('layouts.admin.master')
@section('content')
<div class="row" style="height: 150px">
    <div class="card col-md-4 col-sm-6 col-12">
      <h4 style="margin: 10px 0;"><small>Users | Total: {{ count($users)}}</small></h4>
      <div id="chartPie1"></div>
      <div class="row">
        <div class="col-md-10 col-md-offset-1" style="padding: 0 15px 10px">
          <h6>Legend</h6>
          <i class="fa fa-circle text-info"></i> Benefactors
          <i class="fa fa-circle text-danger"></i> Scholars
          <i class="fa fa-circle" style="color: #FFA534"></i> Admin
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
  <script type="text/javascript">
    function operateFormatter(value, row, index) {
      return [
				'<a rel="tooltip" title="Remove" class="btn btn-link btn-danger table-action remove" href="javascript:void(0)">',
        '<i class="fa fa-remove"></i>',
        '</a>'
      ].join('');
    };
    var sum = function(a, b) { return a + b };
    var roles = <?php echo json_encode($roles); ?>;
    function add(accumulator, a) {
        return accumulator + a;
    }
    const total = roles.reduce(add, 0);
    $admins = Math.floor(((roles[0]/total) * 100));
    $benefactors = Math.floor(((roles[1]/total) * 100));
    $scholars = Math.floor(((roles[2]/total) * 100));
    var data = {
      series: [$admins, $benefactors, $scholars],
      labels: [roles[0], roles[1], roles[2]]
    };
    var pie1 = new Chartist.Pie('#chartPie1', data, {
    });
    var options = {
      seriesBarDistance: 30
    };
    var responsiveOptions = [
      ['screen and (max-width: 640px)', {
        seriesBarDistance: 5,
        axisX: {
          labelInterpolationFnc: function (value) {
            return value[0];
          }
        }
      }]
    ];

  </script>
@endsection