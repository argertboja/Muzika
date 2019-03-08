<?php 
session_start();


$album_ID = $_POST['clicked_song'];

  $db_servername = "dijkstra.ug.bcc.bilkent.edu.tr";
  $db_username = "rubin.daija";
  $db_password = "sm15dzl";
  $db_database = "rubin_daija"; 
 
  // Create connection
  $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_database);
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
  
$purchased_songs = array(array());
$play = " select name, song_ID, DATE_FORMAT(date_published, '%d.%m.%Y') as receipt_date from album_contains natural join song where album_ID = $album_ID ;";
$playlist_result = mysqli_query($conn, $play);
$i = 0;
while($songs_result = mysqli_fetch_assoc($playlist_result)){
	$purchased_songs[$i][0] =  $songs_result["name"];
	$purchased_songs[$i][2] = $songs_result["receipt_date"];	
	
	$temp = $songs_result["song_ID"];
	$play = " select get_singer($temp) as singer;";
	$playlist_resulti = mysqli_query($conn, $play);
	$songs_resulti = mysqli_fetch_assoc($playlist_resulti);
	
	$temp = $songs_resulti["singer"];
	$play = " select art_name from artist where ID = $temp;";
	$playlist_resulti = mysqli_query($conn, $play);
	$songs_resulti = mysqli_fetch_assoc($playlist_resulti);
	$purchased_songs[$i][1] = $songs_resulti["art_name"];
	$purchased_songs[$i][3] = $songs_result["song_ID"];	

  $i++;
}
$nr_songs = count($purchased_songs);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile Customer</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	
	</head>
<body>
   <nav class="navbar navbar-inverse" 
	style="border-color: #663366;
	background-color: #663366; 
	-webkit-box-shadow: 1px 2px 45px 5px rgba(211,76,211,0.71);
	-moz-box-shadow: 1px 2px 45px 5px rgba(211,76,211,0.71);
	box-shadow: 1px 2px 45px 5px rgba(211,76,211,0.71);" >
	<div class="container-fluid" 
	style=" width: 60%;
	background-color: #663366;">
	<div class="navbar-header"   >
		<img  style=" color: #fff ;display: block;margin-left: auto;  margin-right: auto; margin-top: 10px "  src="img/icon.png" width="50" height="45"  href="home.php"></img>
	</div>
	<ul class="nav navbar-nav"  >
		<li><a 
			onMouseOver="this.style.color='#268c04'" 
			onMouseOut="this.style.color='#fff'"  
			style=" font-weight: bold;
			font-size:15pt;
			height: 3em; 
			color: #fff; 
			padding-top: 1px; 
			text-align: center; 
			line-height: 3em;"
			href="profile_artist.php">Home</a>
			
		</li>

		<li class="active"><a  

			style ="color: #fff;
			font-weight: bold;
			font-size:15pt;
			background-color: #db32db;
			height: 3em; 
			padding-top: 1px;
			text-align: center;
			line-height: 3em" 
			href="publish_album.php">Profile</a>
		</li>

		<li >
			<a 
			onMouseOver="this.style.color='#268c04'"
			onMouseOut="this.style.color='#fff'"
			style ="color: #fff;
			font-weight: bold;
			font-size:15pt;
			height: 3em;
			padding-top: 1px;
			text-align: center;
			line-height: 3em"
			href="search.php">Search</a>
		</li>

		<li><a  onMouseOver="this.style.color='#268c04'" 
			onMouseOut="this.style.color='#fff'" 
			style=" color: #fff; 
			font-weight: bold; 
			font-size:15pt; 
			height: 3em; 
			padding-top: 1px; 
			text-align: center; 
			line-height: 3em" 
			href="post_feed.php">Post Feed</a>
		</li>
		<li><a  onMouseOver="this.style.color='#268c04'" 
			onMouseOut="this.style.color='#fff'" 
			style=" color: #fff; 
			font-weight: bold; 
			font-size:15pt; 
			height: 3em; 
			padding-top: 1px; 
			text-align: center; 
			line-height: 3em" 
			href="profile_manager.php">Publish</a>
		</li>

	</ul>
</div>
</nav>

<h2 style="margin-top:10px">ALBUM: <?php 

$play = " select name  from album where album_ID = $album_ID ;";
$playlist_result = mysqli_query($conn, $play);
$songs_result = mysqli_fetch_assoc($playlist_result);
echo $songs_result['name'];
?></h2>
        <hr style="  border:none;
                          width: 40%;
                          height: 50px;
						  margin-left:10px;
                          margin-top: -50px;
						  margin-bottom:50px;
                          border-bottom: 1px solid #fff;
                          box-shadow: 0 20px 20px -20px #333;">

        <table class="table table-hover" style="width: 90%;">
            <tbody>
            <thead>
                <tr>

                    <th>TITLE</th>
                    <th>ARTIST</th>
                    <th>RELEASE DATE</th>
					<th>VIEW</th>

                </tr>
            </thead>
           <?php 
							
								if ($nr_songs > 5) {
								   for($i=0; $i < 5; $i++){								   
									   echo "
										<tr>
									<form method=\"post\" action=\"song.php\">
										<td type=\"submit\" style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">".	 $purchased_songs[$i][0] ."</td>
										<td type=\"submit\" style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $purchased_songs[$i][1]. "</td>
										<td type=\"submit\" style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $purchased_songs[$i][2]. " </td>
										<td type=\"submit\" style=\"font-weight: bold;  border-color: #8d8e8d;\">
										<button class=\"btn btn-success\" type=\"submit\" name=\"clicked_song\" value=".$purchased_songs[$i][3]." >Open</button>
										</td>
									</form></tr>";
									
								   }							   
								}
								else {
									for($i=0; $i < $nr_songs; $i++){
										echo "
										<tr>
									<form method=\"post\" action=\"song.php\">
										<td type=\"submit\" style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">".	 $purchased_songs[$i][0] ."</td>
										<td type=\"submit\" style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $purchased_songs[$i][1]. "</td>
										<td type=\"submit\" style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $purchased_songs[$i][2]. " </td>
										<td type=\"submit\" style=\"font-weight: bold;  border-color: #8d8e8d;\">
										<button class=\"btn btn-success\" type=\"submit\" name=\"clicked_song\" value=".$purchased_songs[$i][3]." >Open</button>
										</td>
									</form></tr>";
								}									
							}
                           
							?>
        </table>
    
              </div>
			  </div>
			  </body>
			  </html>