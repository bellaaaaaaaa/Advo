@extends('layouts.admin.master')
@section('content')
	<div class="card bootstrap-table">
    <div class="card-body table-full-width">
      <div class="toolbar">
      </div>
      <table id="bootstrap-table" class="table" data-url="{{ route('scholar_posts.index') }}">
        <thead>
          <th data-field="id" class="text-center" data-sortable="true">ID</th>
          <th data-field="user_id" class="text-center" data-sortable="true">Scholar ID</th>
          <th data-field="title">Title</th>
          <th data-field="body">Body</th>
          <th data-field="likes">Likes</th>
          <th data-field="comments">Comments</th>
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
