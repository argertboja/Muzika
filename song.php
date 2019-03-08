<?php 
$ID = (int)$_POST["clicked_song"];

$db_servername = "dijkstra.ug.bcc.bilkent.edu.tr";
  $db_username = "rubin.daija";
  $db_password = "sm15dzl";
  $db_database = "rubin_daija"; 
 
  // Create connection
  $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_database);
  if (!$conn) {
	  echo "Connection Failure";
    die("Connection failed: " . mysqli_connect_error());
  }
  
  
$result = $conn->query("SELECT * FROM song WHERE song_ID = '$ID' ;");
       
	   
$query = "select name, num_clicks, price,DATE_FORMAT(date_published, '%d.%m.%Y') as date_published  from song where song_ID=$ID;";
$query_proc = mysqli_query($conn, $query);
$query_result = mysqli_fetch_assoc($query_proc);
$name = $query_result["name"];
$nr_clicks = $query_result["num_clicks"];
$price = $query_result["price"];
$date_published = $query_result["date_published"];


$play = " select get_singer($ID) as singer;";
	$playlist_resulti = mysqli_query($conn, $play);
	$songs_resulti = mysqli_fetch_assoc($playlist_resulti);

$tmp = $songs_resulti["singer"];
$query = "select art_name from artist where ID = $tmp;";
$query_proc = mysqli_query($conn, $query);
$query_result = mysqli_fetch_assoc($query_proc);

$singer = $query_result["art_name"];


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Song</title>
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
<div class="container" style="width: 70%; margin-top: 6%;">
  <div class="col-xs-12">
    <div class="row">
      <h1 style="font-weight: bold"><?php echo $name ?> </h1>
    </div>
    <div class="row">
      <h4 style="font-weight: bold; color:forestgreen">Artist: <?php echo $singer ?></h4>
    </div>
    <div class="row">
      <div class="col-xs-4">
        <div class="row">
          <span style="font-weight: bold; color:forestgreen; margin-bottom:-5px">Clicks:</span>
          <span style="font-weight: bold; color:black; margin-bottom:-5px"><?php echo $nr_clicks ?> </span>
        </div>
        <div class="row">
          <span style="font-weight: bold; color:forestgreen;margin-bottom:-5px">Price: </span>
          <span style="font-weight: bold; color:black; margin-bottom:-5px"><?php echo $price ?> $ </span>
        </div>
        <div class="row">
          <span style="font-weight: bold; color:forestgreen">Published: </span>
          <span style="font-weight: bold; color:black; margin-bottom:-5px"><?php echo $date_published ?> </span>
        </div>
      </div>
      <div class="col-xs-8">
        <div class="row">
          <button type="button" class="btn btn-success"
          style=" font-weight: bold; margin-left:10px;
          margin-top: 15px;
          margin-bottom: 50px;
          font-size: 15pt;
          border-radius: 10px;
          float: left;
          width: 120px;
          height: 40px">
          Purchase
        </button>
        <button type="button" class="btn btn-success"
        style=" font-weight: bold; margin-left:10px;
        margin-top: 15px;
        margin-bottom: 50px;
        font-size: 15pt;
        border-radius: 10px;
        float: left;
        width: 170px;
        height: 40px">
        Add to playlist
      </button>
      <button type="button" class="btn btn-success"
      style=" font-weight: bold; margin-left:10px;
      margin-top: 15px;
      margin-bottom: 50px;
      font-size: 15pt;
      border-radius: 10px;
      float: left;
      width: 100px;
      height: 40px">
      Post
    </button>
    <button type="button" class="btn btn-danger"
    style=" font-weight: bold; margin-left:80px;
    font-size: 15pt;
    margin-top: 15px;
    border-radius: 10px;
    float: left;
    width: 100px;
    height: 40px">
    Report
  </button>
</div>
</div>
</div>
<div class="row">
  <audio controls>
    <source src="horse.ogg" type="audio/ogg">
    </audio>
  </div>

</div>


</div>

</body>
</html>