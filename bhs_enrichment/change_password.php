<!doctype html>
<html lang = "en">	
	<?php
   include("db/connect.php");
   session_start();
   
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $curPass = $_POST['curPass'];
      $newPass = $_POST['newPass'];
	  $confirmPass = $_POST['confirmPass'];
	  
      if($curPass == $_SESSION['pw'] && $newPass==$confirmPass) {
          $sql2 = "UPDATE teachers SET pw='".$newPass."' WHERE employee_id='".$_SESSION['e_id']."'";
		  if($db->query($sql2) === TRUE)
		  {
			  echo '<a href="login.php">Password changed succesfully, click here to return to login.</a>';
		  }
      }
	  
	  else if($curPass != $_SESSION['pw'] || $newPass!=$confirmPass)
         $error = "One or more of your passwords is incorrect or does not match";
      }
   
?>
	<head>
	<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" />
<script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
 
		<title>Change Password</title>
		<style type = "text/css">
			body
			{
				background-color:#CBEBF6;
			}
			
			.header
			{
				font-family:"Raleway", Raleway, sans-serif;
				font-size:1.25em;
			}

			.inputs
			{
				font-family:"Raleway", Raleway, sans-serif;
			}
			
			.curPass
			{
				margin-left:7px;
				margin-bottom:5px;
			}
			
			.newPass
			{
				margin-left:28px;
				margin-bottom:5px;
			}
			
			.confirmPass
			{
				margin-left:5px;
				margin-bottom:5px;
			}
			
			.buttoninput
			{
				position:relative;
				left:128px;
			}

			.box
			{
				border-radius:5px;
				width:500px;
				height:200px;
				background-color:#FFFEDF;
				
				position: absolute;
				top:50%;
				left:50%;
				margin: -125px 0 0 -250px;
			}
		</style>
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
			<div align="center" class = "box">
				<div class="header">
					<br /><b>Change Password</b>
					</br></br>
				</div>
				<form action = "" method = "post">
						<div class="inputs">
							<label>Current Password: <input type="password" name="curPass" class="curPass"/></label>
							</br>
							<label>New Password: <input type="password" name="newPass" class="newPass"/></label>
							</br>
							<label>Confirm Password: <input type="password" name="confirmPass" class="confirmPass"/></label>
							</br>
							<div class="buttoninput"><input type="submit" value="Submit" name="submit"/></div>
						</div>
				</form>
				
				<div style = "color:red"></br><?php if(isset($error))echo $error;?></div>
			</div>
	</body>
</html>