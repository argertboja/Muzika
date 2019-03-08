<?php 
session_start();
     $my_id = 1;
	$db_servername = "dijkstra.ug.bcc.bilkent.edu.tr";
	$db_username = "rubin.daija";
	$db_password = "sm15dzl";
	$db_database = "rubin_daija";
	// Create connection
	$conn = mysqli_connect($db_servername, $db_username, $db_password, $db_database);
	if (!$conn) {
	  //  echo "nOT CONNECTED<br>";
	  die("Connection failed: " . mysqli_connect_error());
	}
	// sql to delete a record
     $sql = "DELETE FROM user WHERE id= $my_id";

    if ($conn->query($sql) === TRUE) {
       echo "Record deleted successfully";
    } else {
       echo "Error deleting record: " . $conn->error;
    }

	//header('Location: profile_artist.php');
	
	
	?>