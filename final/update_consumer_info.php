<?php 
session_start();

	$db_servername = "dijkstra.ug.bcc.bilkent.edu.tr";
	$db_username = "rubin.daija";
	$db_password = "sm15dzl";
	$db_database = "rubin_daija";

	$artistID = 3; // fixed user id 
$_SESSION["email_exists"] = "0";
	// Create connection
	$conn = mysqli_connect($db_servername, $db_username, $db_password, $db_database);
	if (!$conn) {
	  //  echo "nOT CONNECTED<br>";
	  die("Connection failed: " . mysqli_connect_error());
	}
	
	$new_first_name = $_POST["first_name"];
	$new_last_name = $_POST["last_name"];
	$new_email = $_POST["email"];
	
	echo "<h1>hi :$new_first_name : $new_last_name : $new_email  </h1>";
	
	$email_exists = 0;
	$result = $conn->query("SELECT check_user_email($artistID, '$new_email') as exist;");
	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
		  echo "__".$row['exist'];
		if ( $row['exist'] == 0){
			echo "aaaaa";
			$email_exists = 1;
		}	
	  }
	}
	if(!$email_exists){
		$_SESSION["email_exists"] = "exists";
		echo "asdasdsadsdasd";
		//header('Location: customer_profile.php');
	}
echo "<h1>hi3 $email_exists </h1>";	
	
	//$_SESSION["label_exists"] = "not";
	//$_SESSION["email_exists"] = "not";
	
	$sql = "UPDATE user SET first_name = '$new_first_name', last_name = '$new_last_name' WHERE ID = $artistID ";
	if ($conn->query($sql) === TRUE) {
		$update_fl_name = 1;	
	} else {
		$update_fl_name = 0;
	}
	
	echo "<h1>h4 </h1>";
	$sql = "UPDATE user SET email = '$new_email' WHERE ID = $artistID ";
	if ($conn->query($sql) === TRUE) {
		$update_email = 1;
	} else {
		$update_email = 0;
	}
		
	echo "<h1>h6 $update_fl_name  </h1>";
	header('Location: customer_profile.php');
	
	


?>