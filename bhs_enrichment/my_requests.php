<!doctype html>

<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" />
<script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker3.min.css">
<script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>
<style type= "text/css">
	.table-hover>tbody>tr:hover>td, .table-hover>tbody>tr:hover>th{
			background-color: #0099cc;
				color: #ffffff;
	}
	td { cursor: pointer; cursor: hand; }

  </style>
  <script>
	  $(document).ready(function() {
		$('#mytable1, #mytable2, #mytable3, #mytable4, #mytable5').dataTable();
	  });
  </script>
<?php 
require 'db/connect.php';
session_start();
?>
<?php
if(isset($_POST['r_id'])){
	
	$sql = "DELETE FROM requests
			WHERE request_id=".$_POST['r_id'];
    $result2=$db->query($sql);
	$_POST= array();
}

?> 
<?php
			$dates= array(0,0,0,0,0);
			date_default_timezone_set('America/Chicago');
			$cday = getdate();/*current date*/
			$cwd = $cday["wday"];/*current day of the week 0-6*/
			$ct = $cday["hours"];/* current hour*/
			$aday= date('Y-m-d');
			if($ct<15) {
				$aday= date('Y-m-d', strtotime($aday." +1 Weekday"));}
			else{
				if($cwd>=0 && $cwd<=4){ 
					$aday= date('Y-m-d', strtotime($aday. " +2 Weekday"));
				}
				else{
					$aday= date('Y-m-d', strtotime($aday. " +1 Weekday"));
				}
			}
			$d=strftime("%A",strtotime($aday));
			$w=date('N', strtotime($d));
			
			for($i=$w-1; $i<=4;$i++){
				$dates[$i]=$aday;
				$aday = date('Y-m-d', strtotime($aday. '+1 Weekday'));
				}
			for ($i=0; $i<=4; $i++){
				if ($dates[$i]==0){
				$dates[$i]= $aday;
				$aday = date('Y-m-d', strtotime($aday. '+1 Weekday'));
				}
			else{
				$i=4;
			}
			}

		?>

</head>

<body>
<?php
	$weekday= array("Monday","Tuesday","Wednesday","Thursday","Friday");
	
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
        <li><a href="request_form.php">Request Students</a></li> 
		<li class="active"><a href="my_requests.php">My Requests</a></li> 
		<li><a href="my_history.php">My History</a></li>
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
  <h2>My Requests</h2>
  This is a list of students you have called to Enrichment in the next week. 
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#Monday">Monday</a></li>
    <li><a data-toggle="tab" href="#Tuesday">Tuesday</a></li>
    <li><a data-toggle="tab" href="#Wednesday">Wednesday</a></li>
    <li><a data-toggle="tab" href="#Thursday">Thursday</a></li>
	<li><a data-toggle="tab" href="#Friday">Friday</a></li>
  </ul>
  
  <div class="tab-content">
  <?php 
  for($i=0; $i<5; $i++){
	  ?>
    <div id=<?php echo '"'.$weekday[$i].'"'?> class=<?php if($i==0) echo '"tab-pane fade in active"'; else echo '"tab-pane fade"';?>>
      <h4><?php echo $weekday[$i].", ".$dates[$i]?></h4>
      <div class="container">
  <table id="mytable1" class="table table-bordered table-striped table-hover" > 
            <thead> 
                <tr> 
                    <th>Date</th> 
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Grade</th>
					<th>Reason</th>
					
					<th>Delete</th>
                </tr> 
            </thead> 
				
            <tbody>
	<?php 
	$result = $db->query("SELECT request_id, date, student_id, reason FROM requests WHERE employee_id = '".$_SESSION['e_id']."' AND date = '".$dates[$i]."'");
	while ($row =$result->fetch_assoc()) {
			$stu = $db->query("SELECT lname, fname, grade FROM students WHERE student_id = '".$row["student_id"]."'");
			$stu= $stu->fetch_assoc();
	?>		
				
                <tr class='clickable-row' data-toggle="modal" data-target="#myModal" data-rid = <?php echo $row["request_id"]?> data-sid= <?php echo $row["student_id"] ?> data-lname = <?php echo $stu["lname"] ?> data-fname=<?php echo $stu["fname"] ?> >       
                    <td><?php echo $row["date"] ?></td>
                    <td><?php echo $stu["lname"] ?></td>
                    <td><?php echo $stu["fname"] ?></td>
					<td><?php echo $stu["grade"] ?></td>
					<td><?php echo $row["reason"] ?></td>
					<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmModal">Remove Request</button></td>
					
				</tr>  

	<?php }?>  
	
            </tbody> 
            </table>
	<?php if($result->num_rows== 0){
			echo "You have made no requests for this day.";
			}?>			
	<script>
		$(document).on("click", ".clickable-row", function () {
			var s_id = $(this).data('sid');
			var r_id = $(this).data('rid');
			var lname = $(this).data('lname');
			var fname = $(this).data('fname');
			$('#r_id').val(r_id);
			$('#stu_name').val(lname+", "+fname);
			
		});
	</script>	
</div>
    </div>
  <?php }
  ?>
      
  </div>
</div>
<div id="confirmModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="color:red;">Cancel Request</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to cancel this request?</p>
		<form action="" method="post">
			<label>Request ID:</label>
			<input type="text" name="r_id" id="r_id" required="required" style= "border: 0px solid;" value ="" readonly><br />
			<label>Student Name:</label>
			<input type="text" name="stu_name" id="stu_name" required="required" style= "border: 0px solid;" value="" readonly><br />
			<button type="submit" class="btn btn-success">Yes</button>
			<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
		</form>
      </div>
    </div>

  </div>
</div>
</body>
</html>