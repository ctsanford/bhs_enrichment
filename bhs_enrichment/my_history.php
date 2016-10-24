<!doctype html>

<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
<script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>
<script src="jquery/jquery-3.1.1.min.js"></script>
<link href="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" />
<script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<style type= "text/css">
	.table-hover>tbody>tr:hover>td, .table-hover>tbody>tr:hover>th {
			background-color: #4169e1;
				color: #ffffff;
	}
	td { cursor: pointer; cursor: hand; }
</style>
<script>
	  $(document).ready(function() {
		$('#mytable').dataTable();
	  });
</script>
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
		<li><a href="my_requests.php">My Requests</a></li>  
		<li class="active"><a href="my_history.php">History</a></li>
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
  <p>Here is a list of all the students you have requested.</p>
  <table id="mytable" class="table table-bordered table-striped table-hover" > 
            <thead> 
                <tr> 
					<th>Date</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Grade</th>
					<th>Reason</th>
                </tr> 
            </thead> 
				
            <tbody>
			<?php
				require 'db/connect.php';
				session_start();
				$result = $db->query("SELECT student_id, date, reason FROM requests WHERE employee_id= '".$_SESSION['e_id']."'");

				while ($row =$result->fetch_assoc()) { 
				$result2 = $db->query("SELECT lname, fname, grade FROM students WHERE student_id='".$row["student_id"]."'");
				$row2= $result2->fetch_assoc();
			?>
                <tr class='clickable-row' data-toggle="modal" data-target="#myModal" data-id= <?php echo $row["student_id"] ?> data-lname = <?php echo $row2["lname"] ?> data-fname=<?php echo $row2["fname"] ?> >       
                    <td><?php echo $row["date"] ?></td>
					<td><?php echo $row2["lname"] ?></td>
                    <td><?php echo $row2["fname"] ?></td>
					<td><?php echo $row2["grade"] ?></td>
					<td><?php echo $row["reason"] ?></td>
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



</body>
</html>