<?php

	$ID = 1; //get the id from session

 $db_servername = "dijkstra.ug.bcc.bilkent.edu.tr";
  $db_username = "rubin.daija";
  $db_password = "sm15dzl";
  $db_database = "rubin_daija"; 
 
  // Create connection
  $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_database);
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
$sql = "UPDATE user SET user_privacy = 'public' WHERE ID = $ID ";
	if ($conn->query($sql) === TRUE) {
		$update_email = 1;
	} else {
		echo "ERROR";
	}

 header('Location: account_settings.php');
?>