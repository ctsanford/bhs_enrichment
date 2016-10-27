<!doctype html>

<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.1/fullcalendar.min.css" type="text/css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php 
require 'db/connect.php';
session_start();
	if(isset($_POST['r_id'])){
	
	$sql = "DELETE FROM requests
			WHERE request_id=".$_POST['r_id'];
    $result2=$db->query($sql);
	$_POST= array();
}
		
		
		
		
		?>
</head>

<body>
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
<!--- this contains the calendar--->
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div id="bootstrapModalFullCalendar"></div>
            </div>
        </div>
    </div>
<!--- this is the modal--->
<div id="fullCalModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                <h4 id="modalTitle" class="modal-title"></h4>
            </div>
            <div id="modalBody" class="modal-body">
			<form action="" method="post">
			Do you want to delete this request? <br /><br />
			<input type="hidden" name="r_id" id="r_id" required="required" style= "border: 0px solid;" value="" readonly><br />
			<button type= "submit" class="btn btn-danger">Dismiss Request</button>
			<button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
			</form>
			</div>
            
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.1/fullcalendar.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<?php

				$result = $db->query("SELECT request_id,student_id, date, reason FROM requests WHERE employee_id= '".$_SESSION['e_id']."'");
				$events = array();
				while ($row =$result->fetch_assoc()) { 
					$result2 = $db->query("SELECT lname, fname, grade FROM students WHERE student_id='".$row["student_id"]."'");
					$row2= $result2->fetch_assoc();
				$event= array("id"=> $row["request_id"], "title"=> $row2["lname"].", ".$row2["fname"]." -- ".$row["reason"]." , ".$row["date"]."  ", "start"=> $row["date"]  );
					array_push($events, $event);
				}
?>
<script>
    $(document).ready(function() { 
    $('#bootstrapModalFullCalendar').fullCalendar({
        events:<?php
					echo json_encode($events);
				?>,
        header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
        eventClick:  function(event, jsEvent, view) {
            $('#modalTitle').html(event.title);
			$('#r_id').val(event.id);
            $('#fullCalModal').modal();
        },
		navLinks:true
    });
});
</script>


</body>
</html>