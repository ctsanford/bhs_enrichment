<?php
$db = mysqli_connect("127.0.0.1", "root", "", "bhs_enrichment");



if(mysqli_connect_errno($db)){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	
}
?>