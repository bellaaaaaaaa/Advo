@extends('layouts.admin.master')
@section('content')
<div>
  <new-funding-transaction-component><new-funding-transaction-component>
</div>
@endsection

@section('scripts')
  {{-- {!! HTML::script('js/parsley.min.js')!!} --}}
  <script type="text/javascript">
    function operateFormatter(value, row, index) {
      return [
				'<a rel="tooltip" title="Remove" class="btn btn-link btn-danger table-action remove" href="javascript:void(0)">',
        '<i class="fa fa-remove"></i>',
        '</a>'
      ].join('');
    }
  </script>
@endsection
