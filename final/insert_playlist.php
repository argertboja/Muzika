<?php
	session_start();
	echo "<h1 align = \"center\">Album inserted</h1>" ;

	$db_servername = "dijkstra.ug.bcc.bilkent.edu.tr";
	$db_username = "rubin.daija";
	$db_password = "sm15dzl";
	$db_database = "rubin_daija";

	$userID = 1; // fixed user id

	// Create connection
	$conn = mysqli_connect($db_servername, $db_username, $db_password, $db_database);
	if (!$conn) {
		//	echo "nOT CONNECTED<br>";
		die("Connection failed: " . mysqli_connect_error());
	}

	$num_songs_to_be_added = $_POST["num_songs_to_be_added"];
   $songs_to_be_inserted  = array(); // contains 2d array of songs to be added [0][0]  = first song info, [1][0]

   echo $num_songs_to_be_added;
    $album_information = array(4);
echo "aaaaaaaaaaaaaaaaaaaaaaaaaaa".$_POST["id0"]."__";
    
    $album_information['playlistName']      =  $_POST["playlistName"];
    $album_information['shareState']  =  $_POST["shareState"];
    $album_information['description']     =  $_POST["description"];

    echo "hey = ". $_POST["playlistName"]. "<br>";	
	echo "hey = ". $album_information['shareState']. "<br>";	
	echo "hey = ".  $album_information['description']. "<br>";

    for ($i=0; $i < $num_songs_to_be_added ; $i++) {
    echo "<br>uuuuuuuuuuuuu<br>"; 
      array_push( $songs_to_be_inserted, $_POST["id".$i] );
      echo "<br>G".$songs_to_be_inserted[i]. "<br>";
      //echo "<aaaa>".$_POST["id0"] . "<br>"; 
    }

	$playlist_name = $album_information['playlistName'];
	$share = $album_information['shareState'] ;
	$description = $album_information['description'] ;
	// insert album
	
	$sql = "INSERT INTO playlist VALUES ( NULL, $userID, '$playlist_name', '$currdate', '$share', '$description' )";
	if ($conn->query($sql) === TRUE) {
	    echo "New album created successfully<br>";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$playlistID = mysqli_insert_id($conn); 

	for ($i = 0; $i < $num_songs_to_be_added; $i++){
		$temp = (int) $songs_to_be_inserted[i];
		echo $temp . "<br>";
		$sql = "INSERT INTO playlist_contains VALUES( $temp , $playlistID )";
		if ($conn->query($sql) === TRUE) {
	   		 echo "New playlist created successfully<br>";
		} else {
	   		echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

//header("Location: publish_album.php");
	
?>
