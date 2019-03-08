<?php
session_start();
$id_of_user = $_POST["alba"];
echo  $id_of_user;

$my_ID = 7;
$profile_ID = 7; // fixed user id
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
$user_type_query = "select * from production_manager where ID = $profile_ID;";

$resul_user_type = $conn->query($user_type_query);
$resul_user = $conn->query($user_query);
$result_user_type = $resul_user_type->fetch_assoc();
$result_user = $resul_user->fetch_assoc();

  $personal =  array();// personal information array
  array_push($personal,  $result_user["first_name"]);
  array_push($personal,  $result_user["last_name"]);
  array_push($personal,  $result_user_type["label_name"]);
  array_push($personal,  $result_user["email"]);  	  
  
  if($_SESSION["name_failed"] == "yes"){

	//array_push($personal,  $result_user["first_name"]);
	//array_push($personal,  $result_user["last_name"]);  
   //echo "<h1>Failed changing names, keep old ones".$_SESSION["name_failed"]."</h1>";	
 }if($_SESSION["email_failed"] == "yes"){
	//array_push($personal,  $result_user["email"]);  
 //  echo "<h1>Failed changing email, keep old ones</h1>";	
 }if($_SESSION["label_failed"] == "yes"){
	//array_push($personal,  $result_user["label_name"]);  
   //echo "<h1>Failed changing label, keep old ones</h1>";	
 }

 if($_SESSION["label_exists"] == "exists"){
   echo "<h1>Label exists, keep old one</h1>";
	//array_push($personal,  $result_user["label_name"]);    
 }if($_SESSION["email_exists"] == "exists"){
   echo "<h1>Email exists, keep old one</h1>";  
	//array_push($personal,  $result_user["email"]);  
 }



  //array_push($personal,  $result_user_type["label_name"]);
  //array_push($personal,  $result_user["email"]);



 
 $num_songs = "select manager_num_projects($profile_ID) as num;";
 $num_songs_result = mysqli_query($conn, $num_songs);
 $songs_result = mysqli_fetch_assoc($num_songs_result);
 array_push($personal,  $songs_result["num"]);
 array_push($personal,  (int) ($songs_result["num"] / 10));
 $num_songs = "select manager_num_followers($profile_ID) as num;";
 $num_followers_result = mysqli_query($conn, $num_songs);
 $songs_result = mysqli_fetch_assoc($num_followers_result);
 array_push($personal,  $songs_result["num"]);


  $followers =  array();//followers array
  $num_foll = "select user.username from user join follows_production_manager where consumer_ID = user.ID;";
  $num_followers_result = mysqli_query($conn, $num_foll);
  while($songs_result = mysqli_fetch_assoc($num_followers_result)){
    array_push($followers,  $songs_result["username"]);
    $following_nr = count($followers);
  }

  $songs_produced = array(array());
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
	$songs_produced[$i][5]  =$songs_result["album_ID"];
	
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





?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Profile Manager</title>
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


  <h2 style="  border:none;
  width: 40%;
  height: 50px;
  margin-top: -50px;
  margin-left: 110px;
  ">Personal Information</h2>
  <hr style="  border:none;
  width: 40%;
  height: 50px;
  margin-top: -50px;
  margin-left: 90px;
  border-bottom: 1px solid #fff;
  box-shadow: 0 20px 20px -20px #333;">
  <div class="row">
    <div class="col-xs-6">
      <form id = "change_user_info" action="update_user_info.php"   method="post">
        <table class="table table-hover" id="personal_info_table" style="width: 90%;">
          <tbody>
           <tr>
            <th scope="row" style=" font-weight: lighter; font-size: 18px; border-color: transparent;">Name</th>
            <td >
             <input readonly type="text" name="first_name" style="font-weight: bold; font-size: 20px; background-color:transparent; border-color: transparent;" value ="<?php echo $personal[0] ?>"/>
           </td>
         </tr>
         <tr>
          <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Surname</th>
          <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;">
            <input readonly type="text" name="last_name" style="font-weight: bold; font-size: 20px; background-color:transparent; border-color: transparent;" value ="<?php echo $personal[1] ?>"/>
          </td>
        </tr>
        <tr>
          <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Label Name</th>
          <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;">
           <input readonly type="text" name="label_name" style="font-weight: bold; font-size: 20px; background-color:transparent; border-color: transparent;" value ="<?php echo $personal[2] ?>"/>
         </td>
       </tr>
       <tr>
        <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Email</th>
        <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;">
          <input readonly type="text" name="email" style="font-weight: bold; font-size: 20px; background-color:transparent; border-color: transparent;" value ="<?php echo $personal[3] ?>"/>
        </td>
      </tr>
      <tr>
        <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Songs produced</th>
        <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;"><?php echo $personal[4] ?></td>
      </tr>
      <tr>
        <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Badge</th>
        <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;"><?php echo $personal[5] ?></td>
      </tr>
      <tr>
        <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Followers</th>
        <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;"><?php echo $personal[6] ?></td>
      </tr>
      <tr>
        <td style=" border-color: #8d8e8d; height: 0px"></td>
        <td style=" border-color: #8d8e8d; height: 0px"></td>
      </tr>
      <tr>


      </tr>
    </tbody>
  </table>
</form >
<?php
if ($my_ID == $profile_ID) {
 echo "
 <div style=\"margin-top: -4%; padding-bottom: 12%;\">
 <button id=\"edit_personal\" type=\"button\" class=\"btn btn-warning\"  onclick=\" toogle_cells_editable('personal_info_table', false,'save_personal', 'edit_personal', 'edit' )\"  
 style=\" font-weight: bold;
 font-size: 15pt;
 border-radius: 10px;
 float: right;
 width: 20%; 
 height: 100%\">Edit</button>

 <button id=\"save_personal\" type=\"button\" class=\"btn btn-success\" onclick=\" toogle_cells_editable('personal_info_table', true, 'save_personal', 'edit_personal', 'save' )\"  
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
  <input type="file" id="imgupload" style="display:none" />
  <?php 
  if ($my_ID == $profile_ID) {
    echo "
    <button type=\"button\" id=\"OpenImgUpload\" class=\"btn btn-success\"
    style=\" font-weight: bold; background-color:mediumseagreen;
    font-size: 15pt;
    margin-top:10px;
    margin-right:50px;
    border-radius: 10px;
    float: right;
    width: 110px;
    height: 40px\">
    Change                 

    </button> ";
  }
  ?>
</div>
</div>
<div class="row">
  <h2 style="margin-top:50px">Albums Produced</h2>
  <hr style="  border:none;
  width: 40%;
  height: 50px;
  margin-top: -50px;
  margin-left: 10px;
  border-bottom: 1px solid #fff;
  box-shadow: 0 20px 20px -20px #333;">

  <table class="table table-hover" style="width: 90%;" id = "songs_produced_table">
    <tbody>
      <thead>
        <tr>

          <th> ALBUM </th>
          <th>CREATED</th>
          <th>CATEGORY</th>
          <th>SONGS</th>
          <th>CLICKS</th>

        </tr>
      </thead>
      <?php 

      if ($nr_of_songs > 5) {
        for($i=0; $i < 5; $i++){								   
         echo "
         <tr>
		 <form method=\"post\" action=\"show_album.php\">
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">".	 $songs_produced[$i][0] ."</td>
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $songs_produced[$i][1]. "</td>
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $songs_produced[$i][2]. " </td>
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $songs_produced[$i][3]. " </td>
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $songs_produced[$i][4]. " </td>
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\"><button class=\"btn btn-success\" type=\"submit\" name=\"clicked_song\" value=".$songs_produced[$i][5]." >View</button> </td>
		 </form>
         </tr>";

       }							   
     }
     else {
      for($i=0; $i < $nr_of_songs; $i++){
       echo "
       <tr>
		 <form method=\"post\" action=\"show_album.php\">
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">".	 $songs_produced[$i][0] ."</td>
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $songs_produced[$i][1]. "</td>
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $songs_produced[$i][2]. " </td>
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $songs_produced[$i][3]. " </td>
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $songs_produced[$i][4]. " </td>
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\"><button class=\"btn btn-success\" type=\"submit\" name=\"clicked_song\" value=".$songs_produced[$i][5]." >View</button> </td>
		 </form>
         </tr>";

     }									
   }

   ?>

 </table>

 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" style=" font-weight: bold; 
margin-top :-2%;
 font-size: 15pt;
 border-radius: 10px;
 float: left;
 width: 50 %;
 height: 100%">
 See All
</button>


<!-- Modal -->
<div class="modal fade" style="width: 100%; " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="width: 70%; ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:16pt">Albums Produced</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="pre-scrollable">
          <table class="table table-hover" style="width: 100%; ">
            <tbody>
              <thead>
                <tr style="font-size:16pt">

                  <th>ALBUM</th>
                  <th>CREATED</th>
                  <th>CATEGORY</th>
                  <th>SONGS</th>
                  <th>CLICKS</th>

                </tr>
              </thead>
              <?php
              for($i=0; $i < $nr_of_songs; $i++){
               echo "
              <tr>
		 <form method=\"post\" action=\"show_album.php\">
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">".	 $songs_produced[$i][0] ."</td>
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $songs_produced[$i][1]. "</td>
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $songs_produced[$i][2]. " </td>
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $songs_produced[$i][3]. " </td>
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">". $songs_produced[$i][4]. " </td>
         <td style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\"><button class=\"btn btn-success\" type=\"submit\" name=\"clicked_song\" value=".$songs_produced[$i][5]." >View</button> </td>
		 </form>
         </tr>";

             }			
             ?>
           </table>
         </div>
<script type="text/javascript">
  
function get_me_to(a){
  document.getElementById(a).submit();
}


</script>
       </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- end of modal -->
<br>
<br><br><br>


<div class="row" style="width : 100%">
  <div class="col-xs-6">
    <h1 style="margin-left: -100px;">Followers</h1>
    <hr style="  border:none;
    width: 40%;
    height: 50px;
    margin-top: -50px;
    margin-left: -100px;
    border-bottom: 1px solid #fff;
    box-shadow: 0 20px 20px -20px #333;">

    <table class="table table-hover" style="width: 70%; margin-left: -100px;" id="followers_table">
      <tbody>
        <?php
        if ($following_nr > 5) {
          for($i=0; $i < 5; $i++){								   
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
        for($i=0; $i < $following_nr; $i++){
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
   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#followingModal" style=" font-weight: bold; 
   margin-bottom: 60px;
   font-size: 15pt; margin-left:100px;
   border-radius: 10px;
   float: left;
   width: 50 %;
   height: 100%">
   See all
 </button>
 <!-- Modal -->
 <div class="modal fade" id="followingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="pre-scrollable">
        <div class="modal-header">
          <h5 class="modal-title" id="followingModal" style="font-size:16pt">Followers</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-hover" style="width: 70%;">
            <tbody>                                   
             <?php
             for($i=0; $i < $following_nr; $i++){
               echo "
               <tr>
               <form action=\"manager_profile.php\" method=\"post\" id=\"alba_1\">
               <td  style=\"font-weight: bold; font-size: 20px; border-color: #8d8e8d;\">
               <input readonly  onclick=\"goToProfile()\"  type=\"text\" name =\"alba\" value=\"$followers[$i]\" 
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

</body>
</html>

<!-- JAVASCRIPT SCRIPTS -->

<script type="text/javascript">
  function myFunction(tableID) {
    var size = document.getElementById(tableID).rows.length;
    var tab = document.getElementById(tableID);
    alert(tableID);
    var i;
    for (i = 0; i < size - 1; i++) {
      alert("item [" + i + "][1] = " + tab.rows[i].cells[1].innerHTML);
    }
  }

    // b1 = cancel , b2 = save, b3 = edit
    function toogle_cells_editable(tableID, edit_state, button_2, button_3, clicked_from) {
      var num_rows = document.getElementById(tableID).rows.length;   
      var i;

      if(clicked_from === 'edit'){
        document.getElementById (button_2 ).style.display = "block" ; 
        document.getElementById (button_3 ).style.display = "none" ;  
        for (var i = 0; i < num_rows-5; i++) {
			//alert("aaaa");
			var d = document.getElementById(tableID).getElementsByTagName("tr")[i];
			cell = d.getElementsByTagName("td")[0];
			cell.firstElementChild.readOnly = edit_state;
			///cell.setAttribute("contenteditable", edit_state);
		}
  }else if(clicked_from === 'save'){

    var checkIfEmpty = 0;

    for (var i = 0; i < num_rows-5; i++) {
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
$('#OpenImgUpload').click(function () { $('#imgupload').trigger('click'); });

</script>
<script>
  // $(document).ready(function(){
  //       $(".table td, .table  th").click(function() {     
 
  //           var column_num = parseInt( $(this).index() ) + 1;
  //           var row_num = parseInt( $(this).parent().index() )+1;   

  //           var size = 0;

  //          var id = "#" +$(this).closest('table').attr('id')  ;
  //          size =  parseInt( $(id).length );

  //          // $("#result").html( "Row_num =" + row_num + "  ,  Rolumn_num ="+ column_num );  
           
  //           if(id === "#personal_info_table"){
  //             alert("Clicked at " + id);
  //           }else  if(id === "#songs_produced_table"){
  //             alert("Clicked at " + id);
  //           }else if (id ==="#followers_table"){
  //             alert("Clicked at " + id);
  //           }
  //       });

  //   });
</script>

