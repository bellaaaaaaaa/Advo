<div class="card col-md-10 offset-md-1">
  <h4>{{$user->name}} funds the following scholars:</h4>
</div>
<div class="card col-md-10 offset-md-1">
    <h4>Funding Transactions:</h4>
  <div class="card bootstrap-table">
    <div class="card-body table-full-width">
      <table id="bootstrap-table" class="table" data-url="{{ route('funding_transactions.index') }}">
        <thead>
          <th data-field="id" class="text-center" data-sortable="true">#</th>
          <th data-field="scholar_id">Scholar</th>
          <th data-field="funding_target_id">Funding Target</th>
          <th data-field="amount" data-sortable="true">$</th>
          <th data-field="actions" class="td-actions text-right" data-events="operateEvents" data-formatter="operateFormatter">Receipt</th>
        </thead>
      </table>
    </div>
  </div>
</div>
<div class="card col-md-10 offset-md-1">
  <h4>Funding Receipts:</h4>
</div>
<script type="text/javascript">
  function operateFormatter(value, row, index) {
    return [
      '<a rel="tooltip" class="btn btn-link btn-danger table-action" href="">',
      '<i class="fa fa-file-zip-o"></i>',
      '</a>'
    ].join('');
  }
</script>