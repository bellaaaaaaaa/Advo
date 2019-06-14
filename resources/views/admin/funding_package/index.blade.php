@extends('layouts.admin.master')
@section('content')
	<div class="card bootstrap-table">
    <div class="card-body table-full-width">
      <div class="toolbar">
      </div>
      <table id="bootstrap-table" class="table" data-url="{{ route('funding_packages.index') }}">
        <thead>
          <th data-field="id" class="text-center" data-sortable="true">ID</th>
          <th data-field="title" class="text-center" data-sortable="true">Title</th>
          <th data-field="description">Description</th>
          <th data-field="body">Body</th>
          <th data-field="payment_method_type">Payment Method Type</th>
          <th data-field="actions" class="td-actions text-right" data-events="operateEvents" data-formatter="operateFormatter">Actions</th>
        </thead>
      </table>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    function operateFormatter(value, row, index) {
      return [
				'<a rel="tooltip" title="Remove" class="btn btn-link btn-danger table-action remove" href="javascript:void(0)">',
        '<i class="fa fa-remove"></i>',
        '</a>',
        "<a rel='tooltip' title='Edit' class='btn btn-link btn-primary table-action edit' href='javascript:void(0)'>",
        '<i class="fa fa-edit"></i>',
        '</a>',
        "<a rel='tooltip' title='View' class='btn btn-link btn-primary table-action view' href='javascript:void(0)'>",
        '<i class="fa fa-eye"></i>',
        '</a>'
      ].join('');
    }
  </script>
@endsection
