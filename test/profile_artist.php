<?php 
session_start();
$id_of_user = $_POST["alba"];
echo  $id_of_user;

$my_ID = 5;
$profile_ID = 5; // fixed user id
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
  $user_type_query = "select * from artist where ID = $profile_ID;";
    
  $personal =  array();// personal information array
  $resul_user_type = $conn->query($user_type_query);
  $resul_user = $conn->query($user_query);
  $result_user_type = $resul_user_type->fetch_assoc();
  $result_user = $resul_user->fetch_assoc();


   

  
  array_push($personal,  $result_user["first_name"]);
  array_push($personal,  $result_user["last_name"]); 
  array_push($personal,  $result_user_type["art_name"]);
  array_push($personal,  $result_user["email"]);   
  
 
 $num_songs = "select get_num_songs($profile_ID) as num;";
  $num_songs_result = mysqli_query($conn, $num_songs);
  $songs_result = mysqli_fetch_assoc($num_songs_result);
  array_push($personal,  $songs_result["num"]);

  $num_songs = "select nr_of_albums($profile_ID) as num;"; //nr of albumbs
  $num_songs_result = mysqli_query($conn, $num_songs);
  $songs_result = mysqli_fetch_assoc($num_songs_result);
  array_push($personal,  $songs_result["num"]);
 
  $num_songs = "select num_followers_artist($profile_ID) as num;";
  $num_followers_result = mysqli_query($conn, $num_songs);
  $songs_result = mysqli_fetch_assoc($num_followers_result);
  array_push($personal,  $songs_result["num"]);


  $followers =  array();//followers array
  $num_foll = "select user.username from user join follows_artist where consumer_ID = user.ID and artist_ID = $profile_ID;";
  $num_followers_result = mysqli_query($conn, $num_foll);
  while($songs_result = mysqli_fetch_assoc($num_followers_result)){
    array_push($followers,  $songs_result["username"]);
    $following_nr = count($followers);
 }

  $songs_produced = array();
/*   (
  array("Jena Mreter","10-11-2009", "Rap", "7", "18"),
  array("Ti dhe un","10-12-2010", "Rap", "6", "19"),
  array("Ne te dy","12-07-2016", "Hip-hop", "10", "21"),
  array("Pa ty","10-11-2017", "Rap", "8", "22"), 
   array("Jemi ne","13-10-2018", "Hip-Hop", "17", "19"),
  array("Name","Created", "Category", "Songs", "18"),
  array("Name","Created", "Category", "Songs", "18"),
  array("Name","Created", "Category", "Songs", "19"), 
  ); */

  
  $num_foll = "select album_ID, name, DATE_FORMAT(release_date, '%d.%m.%Y') as release_date, category from album natural join creates where manager_ID = $profile_ID;";
  $num_followers_result = mysqli_query($conn, $num_foll);
  $i = 0;
  while($songs_result = mysqli_fetch_assoc($num_followers_result)){
    $songs_produced[$i][0] =  $songs_result["name"];
    $songs_produced[$i][1] = $songs_result["release_date"];
    $songs_produced[$i][2]  =$songs_result["category"];
    $tmp =  $songs_result["album_ID"];
    $clicks = "select get_num_songs_album($tmp) as clicks;";
    $clicks_res = mysqli_query($conn, $clicks);
    $result_clicks = mysqli_fetch_assoc($clicks_res);
    $songs_produced[$i][3] = $result_clicks["clicks"];
     $clicks = "select get_album_clicks($tmp) as clicks;";
    $clicks_res = mysqli_query($conn, $clicks);
    $result_clicks = mysqli_fetch_assoc($clicks_res);
    $songs_produced[$i][4] = $result_clicks["clicks"];
    $i++;
}
    $nr_of_songs = count($songs_produced);


$songs =  array("Noizy", "Koktasi", "LALA", "emailAA", "lala", "suendyd", "usdnaba", "aaaaaaauhiw");  

$my_profile = 1;


  $nr_of_songs = count($songs);
 
  $all_songs = array();

    $query_songs = "select * from song where song_ID in (select song_ID from album_contains where album_ID in  (select album_ID from creates where artist_ID = 5));";

  $result = $conn->query($query_songs);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $arr = Array();
      array_push($arr, $row['name']);
      array_push($arr, $row['num_clicks']);
      array_push($arr, $row['price']);
      array_push($arr, $row['genre']);
      array_push($arr, date('d.m.Y', $row['date_published']));
      array_push($arr, $row['song_ID']);
      array_push($all_songs, $arr);
    }
  }
  $rows = count($all_songs);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Profile Artist</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
</head>
<body style="background-color: #D7E7FA;">

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
			href="profile_artist.php">Profile</a>
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
			href="publish_album.php">Publish Album</a>
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
			href="profile_manager.php">Profile Manager</a>
		</li>

	</ul>
</div>
</nav>
  <!-- NAVIGATION BAR END HERE_____________________________________________________________________________  -->


  <!-- CONTAINER STARTS HERE_______________________________________________________________________________  -->
  <div class="container" style="width: 70%; margin-top: 6%;">
         
  <h2 style="margin-left:120px; ">Personal</h2>
      <hr  style="  border:none;
                    width: 50%;
                    height: 50px;
                    margin-top: -50px;
                    margin-left: 100px;
                    border-bottom: 1px solid #D7E7FA;
                    box-shadow: 0 20px 20px -20px #333;">

      <div class="row"> 
          <div class="col-xs-6">
                <!--TABLE PERSONAL STARTS HERE_________________________________________________________________________  -->
                <table class="table table-hover" id = "personal_info_tab" style="width: 100%; ">
                <tbody >
                    <tr>
                        <th scope="row" style=" font-weight: lighter; font-size: 18px; border-color: transparent;">Name</th>
                        <td  style="font-weight: bold; font-size: 20px; border-color: transparent;">
						<input readonly type="text" style="font-weight: bold; font-size: 20px; background-color:transparent; border-color: transparent;" value ="<?php echo $personal[0] ?>"/>
						</td>
                    </tr>
                    <tr>
                        <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Surname</th>
                        <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;">
						<input readonly type="text" style="font-weight: bold; font-size: 20px; background-color:transparent; border-color: transparent;" value ="<?php echo $personal[1] ?>"/>
						</td>
                    </tr>
                    <tr>
                        <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Art Name</th>
                        <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;">
						<input readonly  type="text" style="font-weight: bold; font-size: 20px; background-color:transparent; border-color: transparent;" value ="<?php echo $personal[2] ?>"/>
						</td>
                    </tr>
                    <tr>
                        <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Email</th>
                        <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;">
						<input readonly type="text" style="font-weight: bold; font-size: 20px; background-color:transparent; border-color: transparent;" value ="<?php echo $personal[3] ?>"/>
						</td>
                    </tr>
                    <tr>
                        <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Songs</th>
                        <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;">
						<input readonly type="text" style="font-weight: bold; font-size: 20px; background-color:transparent; border-color: transparent;" value ="<?php echo $personal[4] ?>"/>
						</td>
                    </tr>
                     <tr>
                        <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Albums</th>
                        <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;">
						<input readonly type="text" style="font-weight: bold; font-size: 20px; background-color:transparent; border-color: transparent;" value ="<?php echo $personal[5] ?>"/>
						</td>
                    </tr>
                     <tr>
                        <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Followers</th>
                        <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;">
						<input readonly type="text" style="font-weight: bold; font-size: 20px; background-color:transparent; border-color: transparent;" value ="<?php echo $personal[6] ?>"/>
						</td>
                    </tr>
                    <tr>
                        <td style=" border-color: #8d8e8d; height: 0px"></td> <td style=" border-color: #8d8e8d; height: 0px"></td>
                    </tr>
                  </tbody>
              </table>
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

              <!--TABLE PERSONAL ENDS HERE_________________________________________________________________________  -->
          </div>

              <div class="col-xs-6" style="margin-top: -50px; ">
               <!--   <form action="upload.php" method="post" enctype="multipart/form-data">
                        Select image to upload:
                        <input type="file" name="fileToUpload" id="fileToUpload"> </form>  -->
                <img id ="blah" src="img/zinjo.jpg" style="float: right;margin-right: 10%; width: 80%; height: 80%; margin-top: 50px;  border-radius: 15px;">

              <button id="browse_button" onclick="activateBrowse()" style="margin-top: 100%;position: absolute; float: left" class="btn btn-default">Change profile picture</button>


 
               <input id="browse" style=" font-weight: bold; color:green;
                                      font-size: 15pt;
                                      margin-top:100%;
                                      position: absolute;
                                      visibility: hidden;
                                      border-radius: 10px;
                                      width: 29%; height:10%;
                                      "" type="file"  onchange="readURL(this);" />
       
				<!--  <?php 
				 // if ($my_profile ==1) {
					//  echo "

     //       <input id=\"browse\" style=\" font-weight: bold; color:green;
     //                                  font-size: 15pt;
     //                                  margin-top:100%;
     //                                  border-radius: 10px;
     //                                  float: right;\" type='file' hidden onchange=\"readURL(this); \" />
     //                    <img id=\"blah\" src=\"#\" style=\"float: right; margin-top:-100%; border-radius: 15px;\" /> 
     //                   ";
				// }
				?> -->
         <!-- <button id="browse_button" class="btn btn-default">Upload</button> -->
           </div>
    </div>
<script type="text/javascript">
  function activateBrowse(){
     document.getElementById("browse").style.visibility = "visible";
      document.getElementById("browse_button").style.visibility = "hidden";

   // alert("asddsa");
}
    // function showHint(j) {
    //     var xmlhttp = new XMLHttpRequest();

    //     xmlhttp.onreadystatechange = function() {
    //         if (this.readyState == 4 && this.status == 200) {
    //            // document.getElementById(inputID).innerHTML = this.responseText;
    //         }
    //     };

    //   xmlhttp.open("GET", "update_picture_http.php?q="+j, false);
    //   xmlhttp.send();
    // }
  

</script>
            <div  class="row">
                    <h2 >Songs</h2>
                    <hr  style="  border:none;
                                  width: 40%;
                                  height: 50px;
                                  margin-top: -50px;
                                  margin-left: -20px;
                                  border-bottom: 1px solid #D7E7FA;
                                  box-shadow: 0 20px 20px -20px #333;">

                    <!--TABLE ALBUMS STARTS HERE_________________________________________________________________________  -->        
                    <table class="table table-hover" id = "albums_tab" style="width: 100%;">
                        <tbody >
                            <thead>
                                <tr>
                                    <th style="border-color: transparent; border-bottom: 2px solid #8d8e8d;" >NAME</th>
                                    <th style="border-color: transparent; border-bottom: 2px solid #8d8e8d;" >CLICKS</th>
                                    <th style="border-color: transparent; border-bottom: 2px solid #8d8e8d;" >PRICE</th>
                                    <th style="border-color: transparent; border-bottom: 2px solid #8d8e8d;" >GENRE</th>
                                    <th style="border-color: transparent; border-bottom: 2px solid #8d8e8d;" >CREATED</th>
                                </tr>
                            </thead>
							
							<?php 
							
							if ($rows > 5) {
							   for($i=0; $i <= 5; $i++){								   
								   echo "
									<tr>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">".	 $all_songs[$i][0] ."</td>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $all_songs[$i][1]. "</td>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $all_songs[$i][2]. " </td>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $all_songs[$i][3]. " </td>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $all_songs[$i][4]. " </td>
									</tr>";
								
							   }							   
							}
							else {
								for($i=0; $i <= $rows; $i++){
									echo "
									<tr>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">".	 $all_songs[$i][0] ."</td>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $all_songs[$i][1]. "</td>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $all_songs[$i][2]. " </td>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $all_songs[$i][3]. " </td>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $all_songs[$i][4]. " </td>
									</tr>";
								}									
							}
                           
							?>

                            <tr>
                                <td style=" border-color: #8d8e8d; height: 0px"></td> <td style=" border-color: #8d8e8d; height: 0px"></td>
                                <td style=" border-color: #8d8e8d; height: 0px"></td> <td style=" border-color: #8d8e8d; height: 0px"></td>
                                <td style=" border-color: #8d8e8d; height: 0px"></td>
                            </tr> 

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
            <div class="modal-dialog modal-dialog-centered" role="document" style="width: 60%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:16pt">Songs Produced</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="pre-scrollable">
                            <table class="table table-hover" style="width: 90%; ">
                                <tbody>
                                <thead>
                                    <tr style="font-size:16pt">
                                    <th  >NAME</th>
                                    <th >CLICKS</th>
                                    <th >PRICE</th>
                                    <th >GENRE</th>
                                    <th >CREATED</th>
                                    <th >VIEW</th>

                                    </tr>
                                </thead>
                                <?php 							
							   for($i=0; $i < $rows; $i++){								   
								   echo "
									<tr>

										<td style=\" font-size: 13px; color:black; border-color: #8d8e8d;\">".	 $all_songs[$i][0] ."</td>
										<td style=\" font-size: 13px; color:black;border-color: #8d8e8d;\">". $all_songs[$i][1]. "</td>
										<td style=\" font-size: 13px; color:black;border-color: #8d8e8d;\">". $all_songs[$i][2]. " </td>
										<td style=\" font-size: 13px; color:black;border-color: #8d8e8d;\">". $all_songs[$i][3]. " </td>
										<td style=\" font-size: 13px; color:black;border-color: #8d8e8d;\">". $all_songs[$i][4]. " </td>
                    <td style=\" font-size: 13px;color:black; border-color: #8d8e8d;\"><form method=\"POST\" action = \"song.php\">
                    <button class=\"btn btn-success\"type = \"submit\" value = \"".$all_songs[$i][5]."\" name = \"clicked_song\">Open</button></form></td>
                      <td style=\" font-size: 13px;color:black; border-color: #8d8e8d;\"></td>
									</tr>";
								
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
              <!--TABLE ALBUM ENDS HERE_________________________________________________________________________  -->


              <!--TABLE SONGS + FOLLOWING START HERE_________________________________________________________________________  -->
              <div class="row"  style="padding-top: 50px;  "> 
              <div class="col-xs-6" >
                 <h2 >Songs</h2>
                    <hr  style="  border:none;
                    width: 70%;
                    height: 50px;
                    margin-top: -50px;
                    margin-left: -20px;
                    border-bottom: 1px solid #D7E7FA;
                    box-shadow: 0 20px 20px -20px #333;">

                <table class="table table-hover" id = "songs_tab" style="width: 90%;">
               <?php 
							
							if ($nr_of_songs > 5) {
							   for($i=0; $i <= 5; $i++){								   
								   echo "
									<tr>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">".	 $songs[$i] ."</td>									
									</tr>";
								
							   }							   
							}
							else {
								for($i=0; $i <= $nr_of_songs; $i++){
									echo "
									<tr>
										<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">".	 $songs[$i] ."</td>
									</tr>";
								}									
							}
                           
							?>
                  </table>
                  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#followingModal" style=" font-weight: bold; margin-left:200px;
                                      margin-bottom: 60px;
                                      font-size: 15pt;
                                      border-radius: 10px;
                                      float: left;
                                      width: 50 %;
                                     height: 100%">
                    See all
                </button>
                <!-- Modal -->
                <div class="modal fade" id="followingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
					<div class="pre-scrollable">
                        <div class="modal-content">
						
                            <div class="modal-header">
                                <h5 class="modal-title" id="followingModal" style="font-size:16pt">Songs</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-hover" style="width: 70%;">
                                    <tbody>
                                    <thead>
                                        <tr>
                                            <th style="font-size:16pt">NAME</th>
                                        </tr>
                                    </thead>
									<?php                              
								      for($i=0; $i <= $nr_of_songs; $i++){
									     echo "
									       <tr>
									       	<td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">".	 $songs[$i] ."</td>
									       </tr>";
								     }									
							        
							        ?>
                                        <tr>
                                            <td style=" border-color: #8d8e8d; height: 0px"></td>
                                        </tr>
                                    </tbody>
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

           <div class="col-xs-6" >
                   <h2 style="margin-left: 2%">Followers</h2>
                    <hr  style="  border:none;
                    width: 70%;
                    height: 50px;
                    margin-top: -50px;
                    margin-left: -2%;
                    border-bottom: 1px solid #D7E7FA;
                    box-shadow: 0 20px 20px -20px #333;">

                <table class="table table-hover" id = "following_tab" style="width: 90%; margin-left: 2%">
				<?php
				           if ($following_nr > 5) {
							   for($i=0; $i <= 5; $i++){								   
								   echo "
									<tr>
										<form action=\"manager_profile.php\" method=\"post\" id=\"alba_1\">
							              <td  style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">
								             <input readonly  onclick=\"goToProfile()\"  type=\"text\" name =\"alba\" value=\"$followers[$i]\" 
											 style = \"background-color : transparent; border-style: none\"  />
							             </td>
						               <form>								
									</tr>";								
							   }							   
							}
							else {
								for($i=0; $i <= $following_nr; $i++){
									echo "
									<tr>
										<form action=\"manager_profile.php\" method=\"post\" id=\"alba_1\">
							              <td  style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">
								             <input readonly  onclick=\"goToProfile()\"  type=\"text\" name =\"alba\" value=\"$followers[$i]\" 
											 style = \"background-color : transparent; border-style: none\"  />
							             </td>
						               <form>								
									</tr>";		
								}									
							}
				?>						
                
                  </table>
                  <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#followingModal2" style=" font-weight: bold; margin-left:200px;
                                      margin-bottom: 60px;
                                      font-size: 15pt;
                                      border-radius: 10px;
                                      float: left;
                                      width: 50 %;
                                     height: 100%">
                    See all
                </button>
                <!-- Modal -->
                <div class="modal fade" id="followingModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
					<div class="pre-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="followingModal2" style="font-size:16pt">See all</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-hover" style="width: 70%;">
								 <thead>
                                        
                                    </thead>
								<?php
                                 for($i=0; $i <= $following_nr; $i++){
									echo "
									<tr>
										<form action=\"manager_profile.php\" method=\"post\" id=\"alba_1\">
							              <td  style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">
								             <input readonly  onclick=\"goToProfile()\"  type=\"text\" name =\"follower\" value=\"$followers[$i]\" 
											 style = \"background-color : transparent; border-style: none\"  />
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
    </div>

</div>
       <br> <br>      

 <!-- Copyright-->
    <div class="footer-copyright py-3 text-center" style="background: black; height: 30px; color: white" >
        <b> © 2018 Copyright:</b>
        <a style= "color: white" href="http://dijkstra.cs.bilkent.edu.tr/~ndricim.rrapi/hw/">
            <strong><i> Muzika </i></strong>
        </a>
    </div>
    <!--/.Copyright -->
  


  
</body>
</html>

<!-- JAVASCRIPT SCRIPTS -->


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
    for (var i = 0; i < num_rows-4; i++) {
		//alert("aaaa");
        var d = document.getElementById(tableID).getElementsByTagName("tr")[i];
        cell = d.getElementsByTagName("td")[0];
		cell.firstElementChild.readOnly = edit_state;
        ///cell.setAttribute("contenteditable", edit_state);
    }	
    if(clicked_from === 'edit'){
      document.getElementById (button_2 ).style.display = "block" ; 
      document.getElementById (button_3 ).style.display = "none" ;  
    }else if(clicked_from === 'save'){
      document.getElementById(button_2 ).style.display = "none" ; 
      document.getElementById(button_3 ).style.display = "block" ;  
    }
}
 
</script>

<script>
    $(document).ready(function(){
        $(".table td, .table  th").click(function() {     
 
            var column_num = parseInt( $(this).index() ) + 1;
            var row_num = parseInt( $(this).parent().index() )+1;   

            var size = 0;

           var id = "#" +$(this).closest('table').attr('id') + " tr" ;
           size =  parseInt( $(id).length );

           // $("#result").html( "Row_num =" + row_num + "  ,  Rolumn_num ="+ column_num );  
          //  alert("Row_num =" + row_num + "  ,  Rolumn_num ="+ column_num + "size = " +  size + "idd = " + id); 
        });

    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width("70%")
                    .height("70%");
            };

            reader.readAsDataURL(input.files[0]);
            document.getElementById("browse").style.visibility = "hidden";
            document.getElementById("browse_button").style.visibility = "visible";
            document.getElementById("b").submit();
        }
    }
	
	$('#OpenImgUpload').click(function () { $('#imgupload').trigger('click'); });

</script>

<style type="text/css">
 .table td {
   cursor: pointer;
 }

 .table th {
    cursor: pointer;
 } 

table>tbody>tr:last-child:hover { 
  background-color:transparent; 
}

table>tbody>tr:last-child { 
  color: transparent; 
}

</style>

<!-- 
edit_personal = edit button personal info table
save_personal = save button personal info table
cancel_personal = cancel button personal info table

 -->