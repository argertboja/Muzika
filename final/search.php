<?php 
    session_start();
  if(isset($_POST["keyword"])){
     $query_on = 1;
  }else {
     $query_on = 0; 
  }
    if($query_on){
       $key_to_search = $_POST["keyword"];
       // echo $key_to_search;
        $db_servername = "dijkstra.ug.bcc.bilkent.edu.tr";
        $db_username = "rubin.daija";
        $db_password = "sm15dzl";
        $db_database = "rubin_daija";

        $artistID = 1; // fixed user id

        // Create connection
        $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_database);
        if (!$conn) {
          //  echo "nOT CONNECTED<br>";
          die("Connection failed: " . mysqli_connect_error());
        }
// SELECT * FROM song WHERE name like '%argert"%';

        $result = $conn->query("SELECT * FROM song WHERE name like '%".$key_to_search."%';");
        $songsArray = array();
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $values = Array();
            array_push($values,  $row["name"]);
            array_push($values,  $row["num_clicks"]);
            array_push($values,  $row["price"]);
            array_push($values,  $row["genre"]);
            $originalDate = $row["date_published"];
            $newDate = date("d-m-Y", strtotime($originalDate));
            array_push($values,  $newDate);
            array_push($songsArray, $values );
          }
        }else{
          echo "";
        }

       // echo sizeof($songsArray) ."<br>";

        $result = $conn->query("SELECT * FROM artist WHERE art_name like '%$key_to_search%';");
        $artistArray = array();
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $values = Array();
            array_push($values,  $row["art_name"]);
            array_push($values,  $row["art_name"]);
            array_push($artistArray, $values );
          }
        }

        $result = $conn->query("SELECT * FROM album WHERE name like '%$key_to_search%';");
        $albumArray = array();
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $values = Array();
            array_push($values,  $row["name"]);
            array_push($values,  $row["category"]);
            array_push($values,  $row["price"]);
            $originalDate = $row["release_date"];
            $newDate = date("d-m-Y", strtotime($originalDate));
            array_push($values,  $newDate);
            array_push($albumArray, $values );
          }
        }

        $result = $conn->query("SELECT * FROM playlist WHERE playlist_name like '%$key_to_search%' AND share_state = 'public';");
        $playlistArray = array();
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $values = Array();
            array_push($values,  $row["playlist_name"]);
            $originalDate = $row["date_created"];
            $newDate = date("d-m-Y", strtotime($originalDate));
            array_push($values, $newDate );
            array_push($values,  $row["description"]);
            array_push($playlistArray, $values );
          }
        }


        $result = $conn->query("SELECT * FROM user NATURAL JOIN consumer WHERE first_name like '%$key_to_search%';");
        $consumerArray = array();
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $values = Array();
            array_push($values,  $row["first_name"]);
            array_push($values,  $row["last_name"]);
            $originalDate = $row["registered_date"];
            $newDate = date("d-m-Y", strtotime($originalDate));
            array_push($values, $newDate);
            array_push($consumerArray, $values );
          }
        }

        $result = $conn->query("SELECT first_name, label_name from user NATURAL JOIN production_manager WHERE first_name like '%$key_to_search%' OR  label_name  like '%$key_to_search%'  ;");
        $managerArray = array();
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $values = Array();
            array_push($values,  $row["first_name"]);
            array_push($values,  $row["label_name"]);
            array_push($managerArray, $values );
          }
        }
      }
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Search</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php 
  //echo  $username ;
?>

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
    <li>
    <li ><a  
  onMouseOver="this.style.color='#268c04'"
      onMouseOut="this.style.color='#fff'"
      style ="color: #fff;
      font-weight: bold;
      font-size:15pt;
      height: 3em; 
      padding-top: 1px;
      text-align: center;
      line-height: 3em" 
      href="publish_album.php">Publish Album</a>
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
      href="newsfeed.php">Post Feed</a>
    </li>

  </ul>
</div>
</nav>
  
<div class="container" style="width: 60%">

   
 
<br><br>
      
     <form id = "search_form" action="search.php"   method="post">
          <input  style="width: 90%; float: left; "  class="form-control" id="focusedInput" name="keyword" onfocus= "this.value=''"; type="text" value="Search here..."> 
          <button  type="submit" class="btn btn-success" style="float: right; " >Search</button> 
      </form> 
                  




 <br><br>
  
  
<?php 
    if(sizeof($songsArray) >= 1){
     echo  "<h1 style=\"font-weight: bold\">Songs related to <i> '$key_to_search' </i></h1>
            <table class=\"table table-hover\">
              <thead>
                <tr>
                  <th>Song name</th>
                  <th>Number of clicks</th>
                  <th>Price</th>
                  <th>Genre</th>
                  <th>Date Published</th>
                </tr>
              </thead>
              <tbody>";

      for ($i = 0; $i < sizeof($songsArray) ; $i++){
          echo "<tr>
                  <td>".$songsArray[$i][0]."</td>
                  <td>".$songsArray[$i][1]."</td>
                  <td>".$songsArray[$i][2]."</td>
                  <td>".$songsArray[$i][3]."</td>
                  <td>".$songsArray[$i][4]."</td>
                </tr>";
     } 
     echo "</tbody> </table>";
   }
?>
    
  
  <?php
    if(sizeof($artistArray) >= 1){
     echo  "<h1 style=\"font-weight: bold\">Artists related to <i> '$key_to_search' </i></h1>
            <table class=\"table table-hover\">
              <thead>
                <tr>
                 <th>Artist name</th>
                 <th>Num. Followers</th>
                 <th>Total Songs </th>
                 <th>Follow </th>
                </tr>
              </thead>
              <tbody>";

      for ($i = 0; $i < sizeof($artistArray) ; $i++){
          echo "
                <tr>
                  <td>".$artistArray[$i][0]."</td>
                  <td>".$artistArray[$i][1]."</td>
                  <td>".$artistArray[$i][2]."</td>
                  <td>".$artistArray[$i][3]."</td>
                </tr>";
     } 
      echo "</tbody> </table>";

   }

   if(sizeof($albumArray) >= 1){
     echo  "<h1 style=\"font-weight: bold\">Albums related to <i> '$key_to_search' </i></h1>
            <table class=\"table table-hover\">
              <thead>
                <tr>
                 <th>Album name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Release date</th>
                <th>Buy</th> 
                </tr>
              </thead>
              <tbody>";

      for ($i = 0; $i < sizeof($albumArray) ; $i++){
          echo "
                <tr>
                  <td>".$albumArray[$i][0]."</td>
                  <td>".$albumArray[$i][1]."</td>
                  <td>".$albumArray[$i][2]."</td>
                  <td>".$albumArray[$i][3]."</td>
                  <td><button>buy</button</td>
                </tr>";   
     } 
       echo "</tbody> </table>";
   }


    if(sizeof($playlistArray) >= 1){
     echo  "<h1 style=\"font-weight: bold\">Public playlists related to <i> '$key_to_search' </i></h1>
            <table class=\"table table-hover\">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Date created</th>
                  <th>Description</th>
                </tr>
              </thead>
              <tbody>";

      for ($i = 0; $i < sizeof($playlistArray) ; $i++){
          echo "
                <tr>
                  <td>".$playlistArray[$i][0]."</td>
                  <td>".$playlistArray[$i][1]."</td>
                  <td>".$playlistArray[$i][2]."</td>
                  <td><button>buy</button</td>
                </tr>";
     } 
      echo "</tbody> </table>";
   }


    if(sizeof($consumerArray) >= 1){
     echo  "<h1 style=\"font-weight: bold\">Consumers related to <i> '$key_to_search' </i></h1>
            <table class=\"table table-hover\">
              <thead>
                <tr>
                 <th>Name</th>
                  <th>Surname</th>
                  <th>Date registered</th>
                  <th> Follow</th>
                </tr>
              </thead>
              <tbody>";

      for ($i = 0; $i < sizeof($consumerArray) ; $i++){
          echo "
                <tr>
                  <td>".$consumerArray[$i][0]."</td>
                  <td>".$consumerArray[$i][1]."</td>
                  <td>".$consumerArray[$i][2]."</td>
                  <td><button class = \"btn btn-success\">follow</button</td>
                </tr>";
      }
        echo "</tbody> </table>"; 
   }


    if(sizeof($managerArray) >= 1){
     echo  "<h1 style=\"font-weight: bold\">Managers related to <i> '$key_to_search' </i></h1>
            <table class=\"table table-hover\">
              <thead>
                <tr>
                 <th>Name</th>
                  <th>Label name</th> 
                </tr>
              </thead>
              <tbody>";

      for ($i = 0; $i < sizeof($managerArray) ; $i++){
          echo "
                <tr>
                  <td>".$managerArray[$i][0]."</td>
                  <td>".$managerArray[$i][1]."</td>
                </tr>";
     } 
       echo "</tbody> </table>";
   }
 ?>
    
 


<br><br><br>
</div>
</body>
</html>
