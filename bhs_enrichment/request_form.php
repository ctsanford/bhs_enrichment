<!doctype html>

<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
<script src="jquery/jquery-3.1.1.min.js"></script>
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>
<link href="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" />
<script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script type ="text/javascript">
var day ="1";
var dt= new Date();
var hour = dt.getHours();
if(hour > 19){
	day = "2";
}
</script> 


<style type= "text/css">
	.table-hover>tbody>tr:hover>td, .table-hover>tbody>tr:hover>th {
			background-color: #4169e1;
				color: #ffffff;
	}
	td { cursor: pointer; cursor: hand; 
	}
	#datepicker {
		z-index: 1151 !important;
	}
</style>

<script>
	  $(document).ready(function() {
		$('#mytable').dataTable();
	  });

</script>
  
  
</head>
<body>
<?php
session_start();
if(isset($_POST['stu_id'])){
	$dates = explode(",", $_POST['date']);
	for($index=0; $index< count($dates); $index++){
		$day= $dates[$index];
		$d= strtotime($day);
		$date = date('Y-m-d',$d);
		if(isset($_POST["reason"]) && $_POST["reason"]!= ""){
			$reason = $_POST["reason"];
		}
		else{
		$reason= $_POST["other_reason"];
		}
		
		$sql = "INSERT INTO requests (student_id, employee_id, date, reason)
			VALUES ( '".$_POST["stu_id"]."' , '".$_SESSION['e_id']."' , '".$date."' , '".$reason."')";
		echo $sql."<br />";
		$result2=$db->query($sql);
	}
	$_POST= array();
}

?> 
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="#">BHS Enrichment</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar" style="color: gold;">
      <ul class="nav navbar-nav">
		<li class="active"><a href="request_form.php">Request Students</a></li> 
        <li><a href="my_requests.php">My Requests</a></li>
		<li><a href="my_history.php">History</a></li>
		<?php
			if($_SESSION['admin']==1)
				echo '<li><a href="manage_conflicts.php">Manage Conflicts</a></li>';
		?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
		<li><a href="change_password.php"><span class="glyphicon glyphicon-cog"></span> Change Password</a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  <h2>All Students</h2>
  <p>Click on the row of the student you would like to request:</p>
  <table id="mytable" class="table table-bordered table-striped table-hover" > 
            <thead> 
                <tr> 
                    <th>Student ID</th> 
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Grade</th>
                </tr> 
            </thead> 
				
            <tbody>
	<?php  
	require 'db/connect.php';
	$result = $db->query("SELECT * FROM students");
	while ($row =$result->fetch_assoc()) { ?>
                <tr class='clickable-row' data-toggle="modal" data-target="#myModal" data-id= <?php echo $row["student_id"] ?> data-lname = <?php echo $row["lname"] ?> data-fname=<?php echo $row["fname"] ?> >       
                    <td><?php echo $row["student_id"] ?></td>
                    <td><?php echo $row["lname"] ?></td>
                    <td><?php echo $row["fname"] ?></td>
					<td><?php echo $row["grade"] ?></td>
				</tr>  

	<?php } ?>  
	
            </tbody> 
            </table>	
	<script>
	$(document).on("click", ".clickable-row", function () {
			var s_id = $(this).data('id');
			var lname = $(this).data('lname');
			var fname = $(this).data('fname');
			$('.student-info').html('<h2>'+ lname + ',' + fname + ' -- ' +s_id +'</h2>');
			$('#stu_id').val(s_id);
			$('#stu_name').val(lname+", "+fname);
			
		});
	</script>	
</div>

 <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class= "modal-title">Request Student</h3>
        </div>
        <div class="modal-body" id = "modal-body">
			<form action="" method="post">
				<label>Student Name:</label>
				<input type="text" name="stu_name" id="stu_name" required="required" style= "border: 0px solid;" value="" readonly><br />
				<label>Student ID:</label>
				<input type="text" name="stu_id" id="stu_id" required="required" style= "border: 0px solid;" value ="" readonly><br />
				<h5><strong>What day would you like to request this student?</strong></h5>		
				<div class="col-md-12">
                    <div class="row">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" id="datepicker" readonly="readonly" class="form-control clsDatePicker"> <span class="input-group-addon"><i id="calIconTourDateDetails" class="glyphicon glyphicon-th"></i></span>

                            </div>
                        </div>
                    </div>
                </div>
				<script>
					 $('#datepicker').datepicker({
						 multidate: true
					 });
				</script>
				<h5><strong>Please select a reason for the request:</strong></h5>
				<label class="radio-inline"><input type="radio" name="reason" value="RTI" required>RTI</label>
				<label class="radio-inline"><input type="radio" name="reason" value="Make-Up Classwork">Make-up Classwork</label>
				<label class="radio-inline"><input type="radio" name="reason" value="Make-Up Test">Make-up Test</label>
				<label class="radio-inline"><input type="radio" name="reason" value="Club Activity">Club Activity</label><br />
				<label class="radio-inline"><input type="radio" name="reason" value=""><input type="text" name="other_reason" value="Other"></label><br /><br />
				<button type="submit" class="btn btn-primary">Submit Request</button> 
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> 
			</form>
        </div>
      </div> 
    </div>
  </div>
 </body>
</html>
			
			