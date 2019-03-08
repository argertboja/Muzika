<?php
	session_start();
	echo "<h1 align = \"center\">Album inserted</h1>" ;

	$db_servername = "dijkstra.ug.bcc.bilkent.edu.tr";
	$db_username = "rubin.daija";
	$db_password = "sm15dzl";
	$db_database = "rubin_daija";

	$artistID = 1; // fixed user id

	// Create connection
	$conn = mysqli_connect($db_servername, $db_username, $db_password, $db_database);
	if (!$conn) {
		//	echo "nOT CONNECTED<br>";
		die("Connection failed: " . mysqli_connect_error());
	}

	$num_songs_to_be_added = $_POST["num_songs_to_be_added".($i)];
    $songs_to_be_inserted  = array(); // contains 2d array of songs to be added [0][0]  = first song info, [1][0]

    $album_information = array(4);

    
    $album_information['album_name']      =  $_POST["albumName"];
    $album_information['album_category']  =  $_POST["albumCategory"];
    $album_information['album_price']     =  $_POST["albumPrice"];
    $album_information['manager_label']   =  $_POST["albumManagerLabel"];	

    echo "hey = ". $_POST["albumName"]. "<br>";	
	echo "hey = ". $album_information['album_category']. "<br>";	
	echo "hey = ". $album_information['album_price']. "<br>";
	echo "hey = ".  $album_information['hey']. "<br>";

    for ($i=0; $i < $num_songs_to_be_added ; $i++) { 
      $values = Array();
      array_push($values, $_POST["nameInput".($i)]);
      array_push($values, $_POST["priceInput".($i)]);
      array_push($values, $_POST["lyricsInput".($i)]);
      array_push($values, $_POST["genreInput".($i)]);  
      array_push($values, $_POST["coArtistInput".($i)]);  
      array_push($songs_to_be_inserted, $values);
    }
    echo "<br><br>";

    $num_total_co_artists = 0;
    $roles_array = array();
    for ($i=0; $i < $num_songs_to_be_added ; $i++) { 
       $temp = $_POST["coArtistInput".($i)];
       $tokenized =  explode(":", $temp);
       if($tokenized[0] == null){
          continue; // no co-artists for this song
       }
       $size = sizeof($tokenized);
       $arr = Array();
       $two = 0;
       for ($j=0; $j < $size-1; $j++){
          if($j == 0){ // put song index
            array_push($arr, $i);
            echo "<br>__putting index = ".$i;
         
          }
          if($two < 2){ // put co-artist then role
            array_push($arr, $tokenized[$j]);
            echo "__putting token = ".$tokenized[$j] ." while j = ". $j;
            echo " and increment = ".$two . "__<br>";
            echo "<br><br>";
            $two++;
             
          }if($two == 2){
            array_push($roles_array, $arr);
            $arr = Array(); 
            array_push($arr, $i);
            $two = 0;
           
          }
       } 
    }


// for ($i=0; $i < sizeof($roles_array) ; $i++) { 
//           for ($j=0; $j < 3 ; $j++) { 
//               echo $roles_array[$i][$j];
            
//           }
//              echo "_<br>";
//     }





    $label = $album_information["manager_label"];
    echo "<br>|". $label . "_<br>"; 
    $result = $conn->query("SELECT ID FROM production_manager WHERE label_name = '$label';");

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$managerID =  $row["ID"];
		}
	}
	echo "<br>Fetched mmanagerID = $managerID , from <b>production_manager</b><br>";
	

	$album_name = $album_information['album_name'];
	$category = $album_information['album_category'];
	$album_price = $album_information['album_price'];
	$currdate = date("Y.m.d");

	// insert album
	$sql = "INSERT INTO album (name, category, price, release_date) VALUES(  '$album_name', '$category', $album_price, '$currdate' )";
	if ($conn->query($sql) === TRUE) {
	    echo "New album created successfully<br>";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$albumID = mysqli_insert_id($conn); 

	$song_name = "pirati";
	$song_price = 2000;
	$lyrics = "hey girl ti me tho...";	
	$genre = "rreppi";

	$price = 100;

  // 2d array:
  //        0     1      2       3      
  //   0   name price  lyrics  genre
  //   array[0][1] = name; // of first song
	$added_songs_ID = array();
	
	//insert song
	for($i = 0; $i < $num_songs_to_be_added; $i++){

		$name_ 	 = $songs_to_be_inserted[$i][0];
		$price_	 = $songs_to_be_inserted[$i][1];
 		$lyrics_ = $songs_to_be_inserted[$i][2];
 		$genre_  = $songs_to_be_inserted[$i][3];
		$sql = "INSERT INTO song VALUES( NULL, '$name_', 0 ,  $price_ , '$lyrics_', '$genre_' , '$currdate')";

		if ($conn->query($sql) === TRUE) {
		    echo "New song <b>$name_</b>  created successfully<br>";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
		$songID = mysqli_insert_id($conn);
		array_push($added_songs_ID, $songID ); 

		//insert album contains
		$sql = "INSERT INTO album_contains VALUES ( $albumID , $songID);";
		if ($conn->query($sql) === TRUE) {
		    echo "New album_contains entry added successfully<br>";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

	
	//insert creates only once
	$sql = "INSERT INTO creates VALUES ($albumID , $managerID , $artistID)";

	if ($conn->query($sql) === TRUE) {
	    echo "New creates entry added successfully<br>";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}

	//$songID = mysqli_insert_id($conn); 
	$quit = false;

	for ($i = 0; $i < $num_songs_to_be_added; $i++){
		echo "$num_songs_to_be_added<br>";
		echo "$num_total_co_artists<br>";
		for ($j = 0; $j < sizeof($roles_array); $j++){
			if($i == $roles_array[$j][0]){
				echo "HA<br>";
				$this_art_name = $roles_array[$j][1];
				$result = $conn->query("SELECT ID FROM artist WHERE art_name = '$this_art_name';");

				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$collaboratorID =  $row["ID"];
						echo "Adding artist = $collaboratorID into contributors<br>";
					}
				}

				//insert album contains
				$this_song_ID = $added_songs_ID[$i];
				$this_role = $roles_array[$j][2];
				echo "value = $this_role<br>";
				$sql = "INSERT INTO contributors VALUES ( $collaboratorID, $this_song_ID , '$this_role' )";

				if ($conn->query($sql) === TRUE) {
				    echo "New contributor <b>$collaboratorID</b> added successfully<br>";
				} else {
				    echo "Error: " . $sql . "<br>" . $conn->error;
				}
				$quit = true;
			}else{
				if($quit){$quit = false; break;}
			}
		}
	}
	echo "DONE";

$_SESSION['album_published_successfuly'] = 1 ;



/*
      2d array:
         0     1      2       3       4
    0   name price producer lyrics  genre
    array[0][1] = name; // of first song

         0          1          2      
    0   array[0]  co-artist  role
    c_array[0][0] = belongs to song indexed at 0;
    c_array[0][1] = belongs to co-artist indexed at song in array[0] // of first  song
    c_array[0][1] = belongs to role of co-artist indexed at 0
    0    coartisti    roli 
    0    coartisti1   roli
    1   coasdasdaas   roli ktij
    */

header("Location: publish_album.php");
	
?>
