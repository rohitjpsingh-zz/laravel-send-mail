@extends('adminlte::page')

@section('title', 'AdminLTE')


@section('content_header')
    <h1 class="m-0 text-dark">Import CSV List</h1>
@stop

@section('content')
<div class="card">
    <!-- Main container -->
    <main>
		<div class="card-body">
            <table class="table table-striped table-bordered" id="table" cellspacing="0" data-provide="datatables" data-ajax="all-import-list">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Broadcast Name</th>
                        <th class="text-center">Input File</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    
                </thead>
            </table>
		</div>
    </main>
</div>

  <!-- Modal -->
  <div id="deleteImportID" class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="remove-record-model">
               {{ method_field('delete') }}
               {{ csrf_field() }}
            <div class="modal-header">
              <h4 class="modal-title">Delete Import</h4>
            </div>
            <div class="modal-body">
                <div style="text-align: center;" class="import_data"></div>
                <h4>Are you sure want to delete this record?</h4>
                <input type="hidden" class="import_id" id="import_id" value="">
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger waves-effect remove-data-from-delete-form" onclick="DeleteImport()">Delete</button>
            </div>
        </div>
      </div>
      
    </div>
  </div>
@stop
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">

    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop
@section('js')
<!-- bs-custom-file-input -->
<script type="text/javascript">

  $(document).ready(function() {
      $('#table').DataTable();
  });

</script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
   
<script type="text/javascript"> 
function deleteImport(userID){
    $('#import_id').val(userID); 
    $('#deleteImportID').modal('show'); 
}

/*$(document).ready(function(){
    $('#data_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            dataType: 'JSON'
        },
        columns: [
            {data: 'broadcast_name', name: 'broadcast_name'},
            {data: 'inputfile', name: 'inputfile'},
            {data: 'action', name: 'action'},
        ]
    });
});    */

function DeleteImport(){
	var import_id = $("#import_id").val();
    $.ajax({
            url: "delete_import_ID",
            type: "post",
            data: {
                'import_id': import_id,
                 "_token": "{{ csrf_token() }}"
            }, 
            success: function(result){
				$('#deleteImportID').modal('hide');
				setInterval('location.reload()', 1000); 
            }
        });
}
</script>
@stop
</html>
