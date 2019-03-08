<?php 
session_start();

	$db_servername = "dijkstra.ug.bcc.bilkent.edu.tr";
	$db_username = "rubin.daija";
	$db_password = "sm15dzl";
	$db_database = "rubin_daija";

	$artistID = 7; // fixed user id 

	// Create connection
	$conn = mysqli_connect($db_servername, $db_username, $db_password, $db_database);
	if (!$conn) {
	  //  echo "nOT CONNECTED<br>";
	  die("Connection failed: " . mysqli_connect_error());
	}
	
	$new_first_name = $_POST["first_name"];
	$new_last_name = $_POST["last_name"];
	$new_label_name = $_POST["label_name"];
	$new_email = $_POST["email"];
	
	echo "<h1>hi :$new_first_name : $new_last_name : $new_label_name : $new_email  </h1>";
	
	
	$label_exists = 0;
	$result = $conn->query("SELECT check_manager_exists_label_update($artistID, '$new_label_name') as exist;");
	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
		if ( $row['exist'] == 0){
			$label_exists = 1;		
		}
	  }
	}
	
	if(!$label_exists){
		$_SESSION["label_exists"] = "exists";
		header('Location: manager_profile.php');
	}
	
	echo "<h1>hi 2 </h1>";
	$email_exists = 0;
	$result = $conn->query("SELECT check_user_email($artistID, '$new_email') as exist;");
	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
		if ( $row['exist'] == 0){
			$email_exists = 1;
		}	
	  }
	}
	if(!$email_exists){
		$_SESSION["email_exists"] = "exists";
			header('Location: manager_profile.php');
	}
echo "<h1>hi3 </h1>";	
	
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
	echo "<h1>h5 </h1>";
	$sql = "UPDATE production_manager SET label_name = '$new_label_name'  WHERE ID = $artistID ";
	if ($conn->query($sql) === TRUE) {
		$update_label = 1;
	} else {
		$update_label = 0;
	}
	$_SESSION["name_failed"] = "no";
	$_SESSION["email_failed"] = "no";
	$_SESSION["label_failed"] = "no";
	
	if( $update_fl_name != 1  ){
		$_SESSION["name_failed"] = "yes";
	}if( $update_email != 1 ){
		$_SESSION["email_failed"] = "yes";
	}if( $update_label != 1 ){
		$_SESSION["label_failed"] = "yes";
	}
	echo "<h1>h6 $update_fl_name  </h1>";
	header('Location: manager_profile.php');
	
	
	
	
	
	
	
	
	
	

	



?>