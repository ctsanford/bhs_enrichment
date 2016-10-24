<!DOCTYPE html>
<!-- Bruin blue: #071689
Bruin gold: #87754D-->

<html lang="en">
	<?php
   include("db/connect.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myEmail = mysqli_real_escape_string($db,$_POST['email']);
      $myPW = mysqli_real_escape_string($db,$_POST['pw']); 
      
      $sql = "SELECT employee_id, admin FROM teachers WHERE email = '".$myEmail."' and pw = '".$myPW."'";
      $result = $db->query($sql);
      $row = $result->fetch_assoc();
	  
      $count = count($row);
		
      if($count == 2) {
         $_SESSION['e_id'] = $row['employee_id'];
		 $_SESSION['admin']= $row['admin'];
		 $_SESSION['pw']= $myPW;
		 
         
         header("location: my_requests.php"); //Don't know the name of our homepage
      }
	  
	  else {
         $error = "Your Email or Password is invalid";
      }
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
 
		<title>BHS Enrichment Login</title>
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
			
			.emailinput
			{
				margin-left:35px;
				margin-bottom:5px;
			}
			
			.pwinput
			{
				margin-left:5px;
				margin-bottom:5px;
			}
			
			.buttoninput
			{
				position:relative;
				left:97px;
			}

			.box
			{
				border-radius:5px;
				width:500px;
				height:350px;
				background-color:#d9d9d9;
				
				position: absolute;
				top:50%;
				left:50%;
				margin: -175px 0 0 -250px;
			}

		</style>
	</head>

	<body>
			<div align="center" class = "box">
				<div class="header">
					</br>
					<img src="Bruin.png" height="150"><br /><b>BHS Enrichment Login</b>
					</br></br>
				</div>
				<form action = "" method = "post">
						<div class="inputs">
							<label>Email: <input type="text" name="email" class="emailinput"></label>
							</br>
							<label>Password: <input type="password" name="pw" class="pwinput"/></label>
							</br>
							<div class="buttoninput"><input type="submit" value="Sign In" name="login"/></div>
						</div>
				</form>
				
				<div style = "color:red"></br><?php if(isset($error))echo $error;?></div>
			</div>
	</body>
</html>