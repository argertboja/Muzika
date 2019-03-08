<?php 
session_start();
$id_of_user = $_POST["alba"];

$my_ID = 1;
$profile_ID = 1	; // fixed user id
  $db_servername = "dijkstra.ug.bcc.bilkent.edu.tr";
  $db_username = "rubin.daija";
  $db_password = "sm15dzl";
  $db_database = "rubin_daija"; 
 
  // Create connection
  $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_database);
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
  $user_query = "select * from user where ID = $profile_ID;";
  $user_type_query = "select ID, gender, DATE_FORMAT(birth_date, '%d.%m.%Y') as birth_date,  DATE_FORMAT(registered_date, '%d.%m.%Y') as registered_date , user_bio from consumer where ID = $profile_ID;";
  $my_profile = 1; ////static now
  $personal = array();

  $resul_user_type = $conn->query($user_type_query);
  $resul_user = $conn->query($user_query);
  $result_user_type = $resul_user_type->fetch_assoc();
  $result_user = $resul_user->fetch_assoc();
  


  $personal =  array();// personal information array  
  array_push($personal,  $result_user["first_name"]);
  array_push($personal,  $result_user["last_name"]); 
  array_push($personal,  $result_user["email"]);   
  array_push($personal,  $result_user_type["gender"]);
  array_push($personal,  $result_user_type["birth_date"]);
  array_push($personal,  $result_user_type["registered_date"]);
  
   if($_SESSION["label_exists"] == "exists"){
   echo "<h1>Label exists, keep old one</h1>";
	//array_push($personal,  $result_user["label_name"]);    
 }if($_SESSION["email_exists"] == "exists"){
   echo "<h1>Email exists, keep old one</h1>";  
	//array_push($personal,  $result_user["email"]);  
 }
  
  
  
$playlists = array(array());
$play = " select playlist_ID, playlist_name, DATE_FORMAT(date_created, '%d.%m.%Y') as date_created, description from playlist where creator_ID = $profile_ID;";
$playlist_result = mysqli_query($conn, $play);
$i = 0;
while($songs_result = mysqli_fetch_assoc($playlist_result)){
	$playlists[$i][0] =  $songs_result["playlist_name"];
	$playlists[$i][1] = $songs_result["date_created"];	
	$playlists[$i][2] = $songs_result["description"];
	$playlists[$i][3] = $songs_result["playlist_ID"];
  $i++;
}
$nr_playlists = count ($playlists);


$purchased_songs = array(array());
$play = " select name, song_ID, DATE_FORMAT(receipt_date, '%d.%m.%Y') as receipt_date from purchase natural join song where ID = $profile_ID ;";
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


$following = array(array());
$query = "select username, ID from user join follows where followed_consumer_ID=ID and following_consumer_ID = $profile_ID; ";
$query_proc = mysqli_query($conn,$query);
$i = 0;
while($query_res = mysqli_fetch_assoc($query_proc)){
	$following[$i][0] =  $query_res["username"];
	$following[$i][1] =  (int)$query_res["ID"];
	$i++;
}

$query = "select ID , label_name from production_manager natural join follows_production_manager where consumer_ID = $profile_ID; ";
$query_proc = mysqli_query($conn,$query);
while($query_res = mysqli_fetch_assoc($query_proc)){
	$following[$i][0] =  $query_res["label_name"];
	$following[$i][1] =  (int)$query_res["ID"];
	$i++;
}

$query = "select ID , art_name from follows_artist join artist where ID=artist_ID and consumer_ID = $profile_ID; ";
$query_proc = mysqli_query($conn,$query);
while($query_res = mysqli_fetch_assoc($query_proc)){
	$following[$i][0] =  $query_res["art_name"];
	$following[$i][1] =  (int)$query_res["ID"];
	$i++;
}


$nr_following = count($following);


$followers = array(array());
$query = "select username, ID  from user join follows where following_consumer_ID=ID and followed_consumer_ID = $profile_ID; ";
$query_proc = mysqli_query($conn,$query);
$i = 0;
while($query_res = mysqli_fetch_assoc($query_proc)){
	$followers[$i][0] =  $query_res["username"];
	$followers[$i][1] =  $query_res["ID"];
	$i++;
}
$nr_followers = count($followers);

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

    <div class="container" style="width: 70%; margin-top: 6%;">      

        <h2>Personal Information</h2>
        <hr style="  border:none;
                    width: 40%;
                    height: 50px;
                    margin-top: -50px;
                    margin-left: -20px;
                    border-bottom: 1px solid #fff;
                    box-shadow: 0 20px 20px -20px #333;">
        <div class="row">
            <div class="col-xs-6">
			   <form id = "change_user_info" action="update_consumer_info.php"   method="post">
                <table class="table table-hover" style="width: 100%; margin-left:-100px" id="personal_info_tab">
                    <tbody >
                    <tr>
                        <th scope="row" style=" font-weight: lighter; font-size: 18px; border-color: transparent;">Name</th>
                        <td  style="font-weight: bold; font-size: 20px; border-color: transparent;">
						<input readonly type="text" name="first_name" style="font-weight: bold; font-size: 20px; background-color:transparent; border-color: transparent;" value ="<?php echo $personal[0] ?>"/>
						</td>
                    </tr>
                    <tr>
                        <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Surname</th>
                        <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;">
						<input readonly type="text"  name="last_name" style="font-weight: bold; font-size: 20px; background-color:transparent; border-color: transparent;" value ="<?php echo $personal[1] ?>"/>
						</td>
                    </tr>                    
                    <tr>
                        <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Email</th>
                        <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;">
						<input readonly type="text" name="email"  style="font-weight: bold; font-size: 20px; background-color:transparent; border-color: transparent;" value ="<?php echo $personal[2] ?>"/>
						</td>
                    </tr>
                    <tr>
                        <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Gender</th>
                        <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;">
						<input readonly type="text" style="font-weight: bold; font-size: 20px; background-color:transparent; border-color: transparent;" value ="<?php echo $personal[3] ?>"/>
						</td>
                    </tr>
                     <tr>
                        <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Birth date</th>
                        <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;">
						<input readonly type="text" style="font-weight: bold; font-size: 20px; background-color:transparent; border-color: transparent;" value ="<?php echo $personal[4] ?>"/>
						</td>
                    </tr>
                     <tr>
                        <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Member Since </th>
                        <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;">
						<input readonly type="text" style="font-weight: bold; font-size: 20px; background-color:transparent; border-color: transparent;" value ="<?php echo $personal[5] ?>"/>
						</td>
                    </tr>
                    <tr>
                        <td style=" border-color: #8d8e8d; height: 0px"></td> <td style=" border-color: #8d8e8d; height: 0px"></td>
                    </tr>
                  </tbody>
                </table>
				</form> 
			 <?php
			 if ($my_profile == 1) {
				 echo "
              <div style=\"margin-top: -4%; padding-bottom: 12%;\">
                     <button id=\"edit_personal\" type=\"button\" class=\"btn btn-warning\"  onclick=\" toogle_cells_editable('personal_info_tab', false,'save_personal', 'edit_personal', 'edit' )\"  
                                    style=\" font-weight: bold;
                                            font-size: 15pt;
                                            border-radius: 10px;
                                            float: right;
                                            width: 20%; 
                                           height: 100%\">Edit</button>

                    <button id=\"save_personal\" type=\"button\" class=\"btn btn-success\" onclick=\" toogle_cells_editable('personal_info_tab', true, 'save_personal', 'edit_personal', 'save' )\"  
                                    style=\" font-weight: bold; 
                                            font-size: 15pt; 
                                            border-radius: 10px; 
                                            float: right; 
                                            width: 20%; 
                                            display: none;
                                            height: 100%\" >Save</button>
              </div> ";
			 }
			   ?>
            </div>
            <div class="col-xs-6">
                <img src="img/zinjo.jpg" style="float: right;margin-right: 10%; width: 70%; height: 70%;  border-radius: 15px;">
            </div>
        </div>

        <h2>My Playlist</h2>
        <hr style="  border:none;
                          width: 40%;
                          height: 50px;
						  margin-left:10px;
                          margin-top: -50px;
                          border-bottom: 1px solid #fff;
                          box-shadow: 0 20px 20px -20px #333;">

        <table class="table table-hover" style="width: 90%;">
            <tbody>
            <thead>
                <tr>

                    <th>NAME</th>
                    <th>CREATED</th>
                    <th>DESCRIPTION</th>

                </tr>
            </thead>
            <tbody>
                <?php 
							
							if ($nr_playlists > 5) {
							   for($i=0; $i < 5; $i++){								   
								   echo "
									<tr>
									<form method=\"post\" action=\"show_playlist.php\">
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">".	 $playlists[$i][0] ."</td>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $playlists[$i][1]. "</td>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $playlists[$i][2]. " </td>
									<td type=\"submit\" style=\"font-weight: bold;  border-color: #8d8e8d;\">
										<button class=\"btn btn-success\" type=\"submit\" name=\"clicked_song\" value=".$playlists[$i][3]." >Open</button>
										</td>
									</form></tr>";
								
							   }							   
							}
							else {
								for($i=0; $i < $nr_playlists; $i++){
									echo "
									<tr>
									<form method=\"post\" action=\"show_playlist.php\">
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">".	 $playlists[$i][0] ."</td>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $playlists[$i][1]. "</td>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $playlists[$i][2]. " </td>
									<td type=\"submit\" style=\"font-weight: bold;  border-color: #8d8e8d;\">
										<button class=\"btn btn-success\" type=\"submit\" name=\"clicked_song\" value=".$playlists[$i][3]." >Open</button>
										</td>
									</form></tr>";
								}									
							}
                           
							?>
            </tbody>
        </table>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" style=" font-weight: bold; margin-left:700px;
                                      margin-bottom: 60px;
                                      font-size: 15pt;
                                      border-radius: 10px;
                                      float: left;
                                      width: 50 %;
                                     height: 100%">
            See All
        </button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:16pt">My Playlist</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="pre-scrollable">
                            <table class="table table-hover" style="width: 90%; ">
                                <tbody>
                                <thead>
                <tr>

                    <th>NAME</th>
                    <th>CREATED</th>
                    <th>DESCRIPTION</th>

                </tr>
            </thead>
                                <?php 							
							   for($i=0; $i < $nr_playlists; $i++){								   
								   echo "
									<tr>
									<form method=\"post\" action=\"show_playlist.php\">
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">".	 $playlists[$i][0] ."</td>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $playlists[$i][1]. "</td>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $playlists[$i][2]. " </td>
									<td type=\"submit\" style=\"font-weight: bold;  border-color: #8d8e8d;\">
										<button class=\"btn btn-success\" type=\"submit\" name=\"clicked_song\" value=".$playlists[$i][3]." >Open</button>
										</td>
									</form></tr>";							
							   }							   
							?>
                            </table>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
              </div>
     <div class="row"  style="padding-top: 30px;  "> 
     <div class="row"  style="padding-top: 30px;  "> 
        <h2 style="margin-top:10px">Purchased Songs</h2>
        <hr style="  border:none;
                          width: 40%;
                          height: 50px;
						  margin-left:10px;
                          margin-top: -50px;
                          border-bottom: 1px solid #fff;
                          box-shadow: 0 20px 20px -20px #333;">

        <table class="table table-hover" style="width: 90%;">
            <tbody>
            <thead>
                <tr>

                    <th>TITLE</th>
                    <th>ARTIST</th>
                    <th>PURCHASED</th>
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
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#songModal" style=" font-weight: bold; margin-left:700px;
                                      margin-bottom: 60px;
                                      font-size: 15pt;
                                      border-radius: 10px;
                                      float: left;
                                      width: 50 %;
                                     height: 100%">
            See All
        </button>
        <!-- Modal -->
        <div class="modal fade" id="songModal" tabindex="-1" role="dialog" aria-labelledby="examplModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="examplModalLongTitle" style="font-size:16pt">Purchased Songs</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="pre-scrollable">
                            <table class="table table-hover" style="width: 90%; ">
                                <tbody>
                                 <thead>
                <tr>

                    <th>TITLE</th>
                    <th>ARTIST</th>
                    <th>PURCHASED</th>
					<th>VIEW</th>
                </tr>
            </thead>
                                <?php 							
							   for($i=0; $i <$nr_songs; $i++){								   
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
							?>
                            </table>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
              </div>
			  </div>
        <div class="row">
            <div class="col-xs-6">
                <h1>Followers</h1>
                <hr style="  border:none;
                          width: 40%;
                          height: 50px;
						  margin-left:10px;
                          margin-top: -50px;
                          border-bottom: 1px solid #fff;
                          box-shadow: 0 20px 20px -20px #333;">

                <table class="table table-hover" style="width: 70%;" >
                    <tbody>
                    <thead>
                        <tr>
                            <th>NAME</th>
                        </tr>
                    </thead>
                    <?php
				           if ($nr_followers > 5) {
							   for($i=0; $i < 5; $i++){								   
								    echo "
									<tr>
										<form action=\"";
										
										$go_to6 = "customer_profile.php";
										
										$result = $conn->query("SELECT * FROM production_manager WHERE ID = ".$followers[$i][1].";");
									
										if ($result->num_rows > 0) {
										  while($row = $result->fetch_assoc()) {
											$go_to6 = "manager_profile.php";
										  }
										}
										
										$result = $conn->query("SELECT * FROM artist WHERE ID = ".$followers[$i][1].";");
									
										if ($result->num_rows > 0) {
										  while($row = $result->fetch_assoc()) {
											$go_to6 = "profile_artist.php";
										  }
										}			
										echo "$go_to6										
										\" method=\"post\" id=\"alba_1\">
							              <td  style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $followers[$i][0] ."</td>
										  <td type=\"submit\" style=\"font-weight: bold;  border-color: #8d8e8d;\">
										<button class=\"btn btn-success\" type=\"submit\" name=\"clicked_song\" value=".$followers[$i][1]." >View</button>
										</td>
						               <form>								
									</tr>";									
							   }							   
							}
							else {
								for($i=0; $i < $nr_followers; $i++){
									echo "
									<tr>
										<form action=\"";
										
										$go_to1 = "customer_profile.php";
										
										$result = $conn->query("SELECT * FROM production_manager WHERE ID = ".$followers[$i][1].";");
										
										
										if ($result->num_rows > 0) {
										  while($row = $result->fetch_assoc()) {
											$go_to1 = "manager_profile.php";
										  }
										}
										
										$result = $conn->query("SELECT * FROM artist WHERE ID = ".$followers[$i][1].";");
									
										if ($result->num_rows > 0) {
										  while($row = $result->fetch_assoc()) {
											$go_to1 = "profile_artist.php";
										  }
										}			
										echo "$go_to1										
										\" method=\"post\" id=\"alba_1\">
							              <td  style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $followers[$i][0] ."</td>
										  <td type=\"submit\" style=\"font-weight: bold;  border-color: #8d8e8d;\">
										<button class=\"btn btn-success\" type=\"submit\" name=\"clicked_song\" value=".$followers[$i][1]." >View</button>
										</td>
						               <form>								
									</tr>";			
								}									
							}
				?>						
                </table>
                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#followers" style=" font-weight: bold; margin-left:200px;
                                      margin-bottom: 60px;
                                      font-size: 15pt;
                                      border-radius: 10px;
                                      float: left;
                                      width: 50 %;
                                     height: 100%">
                    See all
                </button>
                <!-- Modal -->
                <div class="modal fade" id="followers" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
					<div class="pre-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="followingModal3" style="font-size:16pt">See all</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-hover" style="width: 70%;">
								 <thead>
                                        
                                    </thead>
								<?php
                                 for($i=0; $i < $nr_followers; $i++){
									echo "
									<tr>
										<form action=\"";
										
										$go_to3 = "customer_profile.php";
										
										$result = $conn->query("SELECT * FROM production_manager WHERE ID = ".$followers[$i][1].";");
									
										if ($result->num_rows > 0) {
										  while($row = $result->fetch_assoc()) {
											$go_to3 = "manager_profile.php";
										  }
										}
										
										$result = $conn->query("SELECT * FROM artist WHERE ID = ".$followers[$i][1].";");
									
										if ($result->num_rows > 0) {
										  while($row = $result->fetch_assoc()) {
											$go_to3 = "profile_artist.php";
										  }
										}			
										echo "$go_to3										
										\" method=\"post\" id=\"alba_1\">
							              <td  style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $followers[$i][0] ."</td>
										  <td type=\"submit\" style=\"font-weight: bold;  border-color: #8d8e8d;\">
										<button class=\"btn btn-success\" type=\"submit\" name=\"clicked_song\" value=".$followers[$i][1]." >View</button>
										</td>
						               <form>								
									</tr>";		
								}		?>		
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                            </div>
                        </div>
						</div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
               
                <h1> Following</h1>
                <hr style="  border:none;
                          width: 40%;
                          height: 50px;
						  margin-left:10px;
                          margin-top: -50px;
                          border-bottom: 1px solid #fff;
                          box-shadow: 0 20px 20px -20px #333;">

                <table class="table table-hover" style="width: 70%;">
                    <tbody>
                    <thead>
                        <tr>
                            <th>NAME</th>
                        </tr>
                    </thead>
                     <?php
				           if ($nr_following > 5) {
							   for($i=0; $i < 5; $i++){								   
								   echo "
									<tr>
										<form action=\"";
										
										$go_to = "customer_profile.php";
										
										$result = $conn->query("SELECT * FROM production_manager WHERE ID = ".$following[$i][1].";");
										if ($result->num_rows > 0) {
										  while($row = $result->fetch_assoc()) {
											$go_to = "manager_profile.php";
										  }
										}
										
										$result = $conn->query("SELECT * FROM artist WHERE ID = ".$following[$i][1].";");
									
										if ($result->num_rows > 0) {
										  while($row = $result->fetch_assoc()) {
											$go_to = "profile_artist.php";
										  }
										}			
										echo "$go_to										
										\" method=\"post\" id=\"alba_1\">
							              <td  style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $following[$i][0] ."</td>
										  <td type=\"submit\" style=\"font-weight: bold;  border-color: #8d8e8d;\">
										<button class=\"btn btn-success\" type=\"submit\" name=\"clicked_song\" value=".$following[$i][1]." >View</button>
										</td>
						               <form>								
									</tr>";								
							   }							   
							}
							else {
								for($i=0; $i < $nr_following; $i++){
									echo "
									
									<tr> 
							              <td  style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $following[$i][0] ."</td>
										  <td  style=\"font-weight: bold;  border-color: #8d8e8d;\">
									<form action=\"";
									$go_to = "customer_profile.php";
										
										$result = $conn->query("SELECT * FROM production_manager WHERE ID = ".$following[$i][1].";");
										if ($result->num_rows > 0) {
										  while($row = $result->fetch_assoc()) {
											$go_to = "manager_profile.php";
										  }
										}
										
										$result = $conn->query("SELECT * FROM artist WHERE ID = ".$following[$i][1].";");
									
										if ($result->num_rows > 0) {
										  while($row = $result->fetch_assoc()) {
											$go_to = "profile_artist.php";
										  }
										}			
										echo $go_to."\"  method=\"post\" id=\"alba_1\">
									<button class=\"btn btn-success\" type=\"submit\" name=\"clicked_song\" value=".$following[$i][1]." >View</button>
									</form>	</td>
						             								
									</tr>";
								}									
							}
				?>						
                </table>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#following" style=" font-weight: bold; margin-left:200px;
                                      margin-bottom: 60px;
                                      font-size: 15pt;
                                      border-radius: 10px;
                                      float: left;
                                      width: 50 %;
                                     height: 100%">
                    See all
                </button>
                <!-- Modal -->
                <div class="modal fade" id="following" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
					<div class="pre-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="followingModal4" style="font-size:16pt">See all</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-hover" style="width: 70%;">
								 <thead>
                                        
                                    </thead>
								<?php
                                 for($i=0; $i < $nr_following; $i++){
									echo "
									
									<tr> 
							              <td  style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $following[$i][0] ."</td>
										  <td  style=\"font-weight: bold;  border-color: #8d8e8d;\">
									<form action=\"";
									$go_to = "customer_profile.php";
										
										$result = $conn->query("SELECT * FROM production_manager WHERE ID = ".$following[$i][1].";");
										if ($result->num_rows > 0) {
										  while($row = $result->fetch_assoc()) {
											$go_to = "manager_profile.php";
										  }
										}
										
										$result = $conn->query("SELECT * FROM artist WHERE ID = ".$following[$i][1].";");
									
										if ($result->num_rows > 0) {
										  while($row = $result->fetch_assoc()) {
											$go_to = "profile_artist.php";
										  }
										}			
										echo $go_to."\"  method=\"post\" id=\"alba_1\">
									<button class=\"btn btn-success\" type=\"submit\" name=\"clicked_song\" value=".$following[$i][1]." >View</button>
									</form>	</td>
						             								
									</tr>";
								}		?>		
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                            </div>
                        </div>
						</div>
                    </div>
					</div>
              
            </div>
        </div>

    </div>

</body>
</html>

<script type="text/javascript">
function goToProfile(){
	document.getElementById("alba_1").submit();
	
}
  function myFunction(tableID) {
var size = document.getElementById(tableID).rows.length;
    var tab =document.getElementById(tableID);  
    alert(tableID);
    var i ;
  //  for( i =0; i < size-1; i++){
  //    alert("item [" + i + "][1] = "+ tab.rows[i].cells[1].innerHTML  );
  //  }
}

// b1 = cancel , b2 = save, b3 = edit
  function toogle_cells_editable(tableID, edit_state, button_2, button_3, clicked_from) {
      var num_rows = document.getElementById(tableID).rows.length;   
      var i;

      if(clicked_from === 'edit'){
        document.getElementById (button_2 ).style.display = "block" ; 
        document.getElementById (button_3 ).style.display = "none" ;  
        for (var i = 0; i < num_rows-4; i++) {
			//alert("aaaa");
			var d = document.getElementById(tableID).getElementsByTagName("tr")[i];
			cell = d.getElementsByTagName("td")[0];
			cell.firstElementChild.readOnly = edit_state;
			///cell.setAttribute("contenteditable", edit_state);
		}
  }else if(clicked_from === 'save'){

    var checkIfEmpty = 0;

    for (var i = 0; i < num_rows-4; i++) {
     var d = document.getElementById(tableID).getElementsByTagName("tr")[i];
     cell = d.getElementsByTagName("td")[0];
     if( cell.firstElementChild.value === '' ){
      checkIfEmpty  = 1;
    }
  }
  if(!checkIfEmpty){
   document.getElementById("change_user_info").submit();	 
   document.getElementById(button_2 ).style.display = "none" ; 
   document.getElementById(button_3 ).style.display = "block" ; 			
 }else{
   alert("Please fill in all the fields");
 }
}
}
 
</script>