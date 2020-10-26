<!DOCTYPE html>
<html>
<head>
	<title>CRUD Laravel DataTable</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  	<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  	<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
  	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<br>
		<h3 align="center">DataTable In Laravel 6</h3>
		<br>
		<div align="right">
			<button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Create Record</button>
		</div>
		<br>
		<div class="table-responsive">
			<table id="user_table" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th width="35%">First Name</th>
						<th width="35%">Last Name</th>
						<th width="30%">Action</th>
					</tr>
				</thead>
			</table>
		</div>
		<br>
		<br>
	</div>

</body>
</html>

<div id="formModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Record</h4>
        </div>
        <div class="modal-body">
         <span id="form_result"></span>
         <form method="post" id="sample_form" class="form-horizontal">
          @csrf
          <div class="form-group">
            <label class="control-label col-md-4" >First Name : </label>
            <div class="col-md-8">
             <input type="text" name="first_name" id="first_name" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Last Name : </label>
            <div class="col-md-8">
             <input type="text" name="last_name" id="last_name" class="form-control" />
            </div>
           </div>
                <br />
                <div class="form-group" align="center">
                 <input type="hidden" name="action" id="action" value="Add" />
                 <input type="hidden" name="hidden_id" id="hidden_id" />
                 <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
                </div>
         </form>
        </div>
     </div>
    </div>
</div>

<script>
	$(document).ready(function(){
		$('#user_table').DataTable({
			processing: true,
			serverSide: true,
			ajax:{
				url: "{{ route('sample.index') }}"
			},
			columns:[
				{
					data: 'first_name',
					name: 'first_name'
				},
				{
					data: 'last_name',
					name: 'last_name'
				},
				{
					data: 'action',
					name: 'action',
					orderable: false
				},
			],
		});

		$('#create_record').click(function(){
			$('#formModal').modal('show');
			$('#form_result').html('');
		});

		$('#sample_form').submit(function(e){
			e.preventDefault();
			var action_url = '';

			if($('#action').val() == 'Add'){
				action_url = "{{ route('sample.store') }}";
			}

			$.ajax({
				url: action_url,
				method: "POST",
				data: $(this).serialize(),
				dataType: 'json',
				success: function(response){
					var html = "";
					console.log(response);
					if(response.errors){
						html += '<div class="alert alert-danger">';
						for(var i = 0; i<response.errors.length; i++){
							html += '<p>'+ response.errors[i] + '</p>'; 
						}
						html += '</div>';
					}

					if(response.success){
						html = '<div class="alert alert-success">'+ response.success +'</div>'
						$('#sample_form')[0].reset();
						$('#user_table').DataTable().ajax.reload();
					}

					$('#form_result').html(html);
				}
			});
		});
	});
</script>