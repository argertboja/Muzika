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
  
  $user_query = "select username from user where ID = $profile_ID;";
  $resul_user = $conn->query($user_query);
  $result_user = $resul_user->fetch_assoc();
  $username = $result_user["username"];
  
  
?>

	<!DOCTYPE html>
	<html lang="en">
	<head>
		<title >Account Settings</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="bootstrap.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	</head>

	<body>
		<style>
			/* Dropdown Button */
			.dropbtn {
				background-color: #3498DB;
				color: white;
				padding: 16px;
				font-size: 16px;
				border: none;
				cursor: pointer;
			}

				/* Dropdown button on hover & focus */
				.dropbtn:hover, .dropbtn:focus {
					background-color: #2980B9;
				}

			/* The container <div>
			- needed to position the dropdown content */
			.dropdown {
				position: relative;
				display: inline-block;
			}

			/* Dropdown Content (Hidden by Default) */
			.dropdown-content {
				display: none;
				position: absolute;
				background-color: #f1f1f1;
				min-width: 160px;
				box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
				z-index: 1;
			}

				/* Links inside the dropdown */
				.dropdown-content a {
					color: black;
					padding: 12px 16px;
					text-decoration: none;
					display: block;
				}


					/* Change color of dropdown links on hover */
					.dropdown-content a:hover {
						background-color: #ddd
					}

			/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
			.show {
				display: block;
			}
		</style>
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
		<li class="active"><a  

			style ="color: #fff;
			font-weight: bold;
			font-size:15pt;
			background-color: #db32db;
			height: 3em; 
			padding-top: 1px;
			text-align: center;
			line-height: 3em" 
			href="publish_album.php">Account Settings</a>
		</li>

	</ul>
</div>
</nav>

		<div class="container" style="width: 70%; margin-top: 6%;">
			<div class="row">
				<div class="col-xs-6">
					<h1 style="font-weight: bold; margin-bottom: 50px; float:left">Account settings</h1>
				</div>
			</div>
			<h2>General Settings</h2>
			<hr style="  border:none;
						width: 40%;
						height: 50px;
						margin-top: -50px;
						margin-left: -20px;
						border-bottom: 1px solid #fff;
						box-shadow: 0 20px 20px -20px #333;">
			<div class="row">
            <div class="col-xs-12">
			
                <table class="table table-hover" style="width: 100%; margin-left:-100px" id="personal_info_tab">
                    <tbody >
                    
                    <tr>
                        <th scope="row" style="font-weight: lighter; font-size: 18px; border-color: #8d8e8d;">Deactivate</th>
                        <td  style="font-weight: bold; font-size: 20px; border-color: #8d8e8d;">Clicking on the red button on the right will immediately delete your account</td>
						<td>
						<form method="post" action="deactivate.php">
						<button type="submit" class="btn btn-danger" 
							style=" font-weight: bold;
										  font-size: 13pt;
										  margin-top:10px;
										  border-radius: 10px;
										  float: left;
										  width: 110px;
										  height: 40px">
						Deactivate
					</button>
					</form> </td> </tr>					
                  
                    <tr>
                        <td style=" border-color: #8d8e8d; height: 0px"></td> <td style=" border-color: #8d8e8d; height: 0px"></td>
                    </tr>
                  </tbody>
                </table>
				
</div>
			
			
			<br />
			<br />
			  <div class="col-xs-12">
			<h2 style="margin-left:-100px;">Privacy Settings</h2>
			<hr style="  border:none;
						width: 40%;
						height: 50px;
						margin-top: -50px;
						margin-left:-140px;
						border-bottom: 1px solid #fff;
						box-shadow: 0 20px 20px -20px #333;">
						
			
			<div class="row">
				<div class="col-xs-4">
				</div>
				<div class="col-xs-4">
					<h3> Who can see your profile?</h3>
				</div>
				<div class="col-xs-4">
							<!-- Single button -->
				   <div class="btn-group">
			     	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
	                             style="background-color:orange;
										  font-size: 11pt;
										  margin-top:20px;
										  border-radius: 5px;
										  float: left;
										  width: 100px;
										 height: 29px">
		                         Chose <span class="caret"></span>
	                  </button> 
	                  <ul class="dropdown-menu">
	             	   <li><a href="followers_privacy.php">Followers</a></li>
	            	  <li><a href="public_privacy.php">Everyone</a></li>	           
	                   </ul>
	               </div>
				</div>
			</div
			
		
			<br />
			<br />
			
			<?php 
			
			if ( $profile_ID == 1 || $profile_ID == 5){
			echo "<h2 style=\"margin-left:-80px;\">Credit Balance</h2>
			<hr style=\"  border:none;
						width: 40%;
						height: 50px;
						margin-top: -50px;
						margin-left: -140px;
						border-bottom: 1px solid #fff;
						box-shadow: 0 20px 20px -20px #333;\">
			<div class=\"row\">
				<div class=\"col-xs-4\">
					<h3 style=\"font-weight:bold\"> Remainig credit</h3>
				</div>
				<div class=\"col-xs-4\">
					<h3> 155000$</h3>
				</div>
				<div class=\"col-xs-4\">
					<button type=\"button\" class=\"btn btn-success\"
							style=\" font-weight: bold; background-color:mediumseagreen;
										  font-size: 15pt;
										  margin-top:10px;
										  border-radius: 10px;
										  float: left;
										  width: 100px;
										 height: 40px\">
						Add
					</button>
				</div>
			</div>";
			}
			?>
			
			
	</body>
	</html>
<script>

function toogle_cells_editable(tableID, edit_state, button_2, button_3, clicked_from) {

        var d = document.getElementById(tableID).getElementsByTagName("tr")[0];
        cell = d.getElementsByTagName("td")[0];
	    cell.firstElementChild.readOnly = edit_state;
        //cell.setAttribute("contenteditable", edit_state);
    if(clicked_from === 'edit'){
      document.getElementById (button_2 ).style.display = "block" ; 
      document.getElementById (button_3 ).style.display = "none" ; 
    }else if(clicked_from === 'save'){
      document.getElementById(button_2 ).style.display = "none" ; 
      document.getElementById(button_3 ).style.display = "block" ;  
    }
}

</script>