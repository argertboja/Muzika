<!DOCTYPE html>
	<?php
	    session_start();
		$connection = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","rubin.daija","sm15dzl","rubin_daija");
		$connection2 = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","rubin.daija","sm15dzl","rubin_daija");
		$connection3 = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","rubin.daija","sm15dzl","rubin_daija");
		$simpleconnection = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","rubin.daija","sm15dzl","rubin_daija");
		if(isset($_POST['logout'])) {
			session_start();
			
			$_SESSION['cid'] = -1;
			session_destroy();
			header("Location: index.php");
		}	
		echo $_POST['postText'] ;
		if ($_POST['postText'] != "" || $_POST['attachmentType'] != "" || $_POST['attachmentValue'] != "") {
			$playlistID = $_POST['attachmentValue'];
			$songID = $_POST['attachmentValue'];
			$albumID = $_POST['attachmentValue'];
			$postedText = $_POST['postText'];
			if (strcmp($_POST['attachmentType'], "album") == 0) { 
				$playlistID = NULL;
				$songID = NULL;
			}
			if (strcmp($_POST['attachmentType'], "song") == 0) { 
				$playlistID = NULL;
				$albumID = NULL;
			}
			if (strcmp($_POST['attachmentType'], "playlist") == 0) { 
				$albumID = NULL;
				$songID = NULL;
			}
			if($playlistID) { 
				$_POST['postText'] = "";
				$_POST['attachmentType'] = "";
				$_POST['attachmentValue'] = "";
				$songs = mysqli_query($simpleconnection,"INSERT INTO post (ID, post_date, playlist_ID, song_ID, album_ID, texti ) values(".$_SESSION['cid'].", NOW(),".$playlistID.",null,null, '".$postedText."');");
			}
			if($songID) { 
				$_POST['postText'] = "";
				$_POST['attachmentType'] = "";
				$_POST['attachmentValue'] = "";
				$songs = mysqli_query($simpleconnection,"INSERT INTO post (ID, post_date, playlist_ID, song_ID, album_ID, texti ) values(".$_SESSION['cid'].", NOW(),null,".$songID.",null, '".$postedText."');");
			}
			if($albumID) { 
				$_POST['postText'] = "";
				$_POST['attachmentType'] = "";
				$_POST['attachmentValue'] = "";
				$songs = mysqli_query($simpleconnection,"INSERT INTO post (ID, post_date, playlist_ID, song_ID, album_ID, texti ) values(".$_SESSION['cid'].", NOW(),null,null,".$albumID.", '".$postedText."');");
			}
		}
	?>
	<script>
		// Variables for checking previous attachment
		var albumprevid = -1;
		var songprevid = -1;
		var playlistprevid = -1;

		// Function for attaching an album
		function appendAlbumAttachment(value) {
			document.getElementById('attachmentValue').value = value;
			document.getElementById("playlistbtn").disabled = true;
			document.getElementById("songbtn").disabled = true;
			document.getElementById("cancel").style.display = 'block';
			document.getElementById("attachmentType").value = "album";
			var eltID = document.getElementById("postArea");
			var element =  document.getElementById("imgid" + albumprevid);
			if (typeof(element) != 'undefined' && element != null)
			{
			  eltID.removeChild(element);
			}
			var a = document.createElement("img");
			a.style.width = "50%";
			a.src = "images/"+value+".jpg";
			a.id = "imgid"+value;
			albumprevid = value;
			eltID.appendChild(a);
			$("#albumModal").modal("hide");

		}

		// Function for attaching a Playlist
		function appendPlaylistAttachment(value) {
			document.getElementById('attachmentValue').value = value;
			document.getElementById("albumbtn").disabled = true;
			document.getElementById("songbtn").disabled = true;
			document.getElementById("attachmentType").value = "playlist";
			document.getElementById("cancel").style.display = 'block';
			var eltID = document.getElementById("postArea");
			var element =  document.getElementById("imgid" + playlistprevid);
			if (typeof(element) != 'undefined' && element != null)
			{
			  eltID.removeChild(element);
			}
			var a = document.createElement("img");
			a.style.width = "50%";	
			a.src = "images/"+value+".jpg";
			a.id = "imgid"+value;
			playlistprevid = value;
			eltID.appendChild(a);
			$("#playlistModal").modal("hide");

		}

		// Function for attaching a Song
		function appendSongAttachment(value) {
			document.getElementById('attachmentValue').value = value;
			document.getElementById("playlistbtn").disabled = true;
			document.getElementById("albumbtn").disabled = true;
			document.getElementById("cancel").style.display = 'block';
			document.getElementById("attachmentType").value = "song";
			var eltID = document.getElementById("postArea");
			var element =  document.getElementById("imgid" + songprevid);
			if (typeof(element) != 'undefined' && element != null)
			{
			  eltID.removeChild(element);
			}
			var a = document.createElement("img");
			a.style.width = "50%";
			a.src = "images/"+value+".jpg";
			a.id = "imgid"+value;
			songprevid = value;
			eltID.appendChild(a);
			$("#songModal").modal("hide");

		}

		// Function for removing attachment
		function removeAttachment() { 
			var eltID = document.getElementById("postArea");
			var element1 =  document.getElementById("imgid" + songprevid);
			var element2 =  document.getElementById("imgid" + playlistprevid);
			var element3 =  document.getElementById("imgid" + albumprevid);
			if (typeof(element1) != 'undefined' && element1 != null)
			{
			  eltID.removeChild(element1);
			}
			if (typeof(element2) != 'undefined' && element2 != null)
			{
			  eltID.removeChild(element2);
			}
			if (typeof(element3) != 'undefined' && element3 != null)
			{
			  eltID.removeChild(element3);
			}
			document.getElementById("cancel").style.display = 'none';
			document.getElementById("songbtn").disabled = false;
			document.getElementById("playlistbtn").disabled = false;
			document.getElementById("albumbtn").disabled = false;
			document.getElementById("attachmentType").value = "";
			document.getElementById("attachmentValue").value = "";
		}

	</script>
	
<html lang="en">
<head>
    <title>MUZIKA ~ News Feed</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/style_index.css">	
    <link rel="icon" href="images/icon.png" type="image/png" size="16x16"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type='text/javascript' src='js/addrow.js'></script>
</head>
<body style="background-image: url('images/bg.png'); background-attachment: fixed;" >
	<?php
		if(isset($_SESSION['cid']) && $_SESSION['cid']!=-1){
			$songs = mysqli_query($simpleconnection, "SELECT song_ID, name FROM song NATURAL JOIN purchase WHERE ID=".$_SESSION['cid'].";");
			$playlists = mysqli_query($connection, "CALL get_sharable_playlists(".$_SESSION['cid'].")");
			if ($_SESSION['role'] == 2) {
				$albums = mysqli_query($connection2, "CALL get_artist_owned_albums(".$_SESSION['cid'].")");
			}
			else {
				$albums = mysqli_query($connection2, "CALL get_user_owned_albums(".$_SESSION['cid'].")");
			}
			$posts = mysqli_query ($connection3, "CALL get_post_for_user(".$_SESSION['cid'].")");
		}
		else{
			header('Location: index.php');
		}
		$myData = mysqli_query($simpleconnection, "SELECT first_name, last_name FROM user WHERE ID=".$_SESSION['cid'].";");
		$myData2 = mysqli_fetch_assoc($myData);
		$myname = $myData2['first_name'];
		$mysurname = $myData2['last_name'];

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
		<li>
						<a 
						onMouseOver="this.style.color='#268c04'"
			onMouseOut="this.style.color='#fff'"
			style ="color: #fff;
			font-weight: bold;
			font-size:15pt;
			height: 3em;
			padding-top: 15px;
			text-align: center;
			line-height: -8em">
							<?php echo "<form method=\"POST\" action=\"newsfeed.php\"><input type=\"submit\" class=\"login__submit\" value=\"Logout\" name=\"logout\"/></form>";?>
						</a>
					</li>
	</ul>
</div>
</nav>
	<header id="myCarousel" class="carousel slide" data-ride="carousel">
	    <div class="modal fade" id="albumModal" role="dialog">
	        <div class="modal-dialog">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal">&times;</button>
	                    <h3 style="text-align: center" class="modal-title">Album</h3>
	                </div>
	                <div class="modal-body">
					    <input type="text" class="form-control" id="myInput" placeholder="Search"/>
						<div id="myDIV" class="pre-scrollable" style="height:100px;">
						  	<div class="list-group">
						    	<?php
					                $in = false;
					                while($row = mysqli_fetch_assoc($albums)) {
					                    $in = true;
					                    echo " 
					                    <div class=\"row\" style=\"margin-left:0%; width:100%;\">
					                    	<a class=\"list-group-item\"id=\"".$row['album_ID']."\" onclick=\"appendAlbumAttachment(".$row['album_ID'].")\">".$row['name']."</a>
					                    </div>";
					                }
			                    ?>
			                </div>
						</div>						    
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="modal fade" id="playlistModal" role="dialog">
	        <div class="modal-dialog">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal">&times;</button>
	                    <h3 style="text-align: center" class="modal-title">Playlist</h3>
	                </div>
	                <div class="modal-body">
	                	<input type="text" class="form-control" id="myInput" placeholder="Search"/>
						<div id="myDIV" class="pre-scrollable" style="height:100px;">
						  	<div class="list-group">
						    	<?php
					                $in = false;
					                while($row = mysqli_fetch_assoc($playlists)) {
					                    $in = true;
					                    echo " 
					                    <div class=\"row\" style=\"margin-left:0%; width:100%;\"><a class=\"list-group-item\"id=\"".$row['playlist_ID']."\" onclick=\"appendPlaylistAttachment(".$row['playlist_ID'].")\"name=\"pl\">".$row['playlist_name']."</a>
					                    </div>";
					                }
			                    ?>
			                </div>
					    </div>	
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="modal fade" id="songModal" role="dialog">
	        <div class="modal-dialog">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal">&times;</button>
	                    <h3 style="text-align: center" class="modal-title">Song</h3>
	                </div>
	                <div class="modal-body">
	                	<input type="text" class="form-control" id="myInput" placeholder="Search"/>
						<div id="myDIV" class="pre-scrollable" style="height:100px;">
						  	<div class="list-group">
						    	<?php
					                $in = false;
					                while($row = mysqli_fetch_assoc($songs)) {
					                    $in = true;
					                    echo " 
					                    <div class=\"row\" style=\"margin-left:0%; width:100%;\"><a class=\"list-group-item\"id=\"".$row['song_ID']."\" onclick=\"appendSongAttachment(".$row['song_ID'].")\">".$row['name']."</a>
					                    </div>";
					                }
			                    ?>
			                </div>
					    </div>	
	                </div>
	            </div>
	        </div>
	    </div>
	</header>
	<div class="container">
		<div class="panel panel-default panel-transparent" style="width:60%; margin-left:20%;">
			<div class="panel-body">
				<div class="form-group">
					<?php 
						echo "<label class=\"col-sm-2 control-label\" style=\"font-size: 14px;\"><img src=\"images/".$_SESSION['cid'].".jpg\"/></label>";
					?>
				    <div class="col-sm-10" id="postArea">
					  	<form method="POST" action="newsfeed.php" id="postForm">
							<input type="textarea" class="form-control" style="height:120px" id="focusedInput" type="text" placeholder="Check this out..." name="postText"/>
				  			<input type="text" value="" style="display:none;" id="attachmentType" name="attachmentType"/>
				  			<input type="text" value="" style="display:none;" id="attachmentValue" name="attachmentValue"/>
				  		</form>							
				  	</div>
				</div>
				<div style="margin-left: 25%;">
					<div class="col-sm-4">
						<a data-toggle="modal" data-target="#albumModal" href="#">
							<input type="submit" id="albumbtn" class="btn btn-success btn-lg" style="padding: 8px 15px; " value="Album" name="album"/>
						</a>
					</div>
					<div class="col-sm-4">
						<a data-toggle="modal" data-target="#playlistModal" href="#">
							<input type="submit" id="playlistbtn" class="btn btn-success btn-lg" style="padding: 8px 15px; " value="Playlist" name="playlist"/>
						</a>
					</div>
					<div class="col-sm-4">
						<a data-toggle="modal" data-target="#songModal" href="#">
							<input type="submit" id="songbtn" class="btn btn-success btn-lg" style="padding: 8px 15px; " value="Song" name="song"/>
						</a>
					</div>
					<div class="col-sm-4" id="cancel" style="display:none;">
						<button type="reset" onclick="removeAttachment()" class="btn btn-success btn-lg" style="padding: 8px 15px; " value="Cancel" name="cancel">Cancel</button>
					</div>
				</div>
				<div align="right" style="margin-top:15%;">
					<button type="button" onclick="checkVals()" name ="postcomment" style="padding: 10px 25px;" class="btn btn-success btn-lg"  >POST</button>
				</div>					
			</div>
		</div>

        <div class="panel-group">
		<?php
            $in = false;
            while($row2 = mysqli_fetch_assoc($posts)) {
                $in = true;
                $numSongs = "";
                $categories = "";
                $title = "";
                if(!$row2['song_ID'] && !$row2['playlist_ID'] && !$row2['album_ID'] )
                	$defaultImg = "default";
                else {
                	if ($row2['song_ID']) { 
                		$defaultImg = $row2['song_ID'];
                		$categ2 = mysqli_fetch_assoc( mysqli_query($simpleconnection, "SELECT name FROM song WHERE song_ID=".$row2['song_ID'].";"));
                		$title = $categ2['name'];
                	}else if ($row2['playlist_ID']) { 
                		$defaultImg = $row2['playlist_ID'];
                		$categ1 = mysqli_fetch_assoc( mysqli_query($simpleconnection, "SELECT playlist_name FROM playlist WHERE playlist_ID=".$row2['playlist_ID'].";"));
                		$title = $categ1['playlist_name'];
                	}else if ($row2['album_ID']) {
                		$defaultImg = $row2['album_ID'];
                		$test = mysqli_fetch_assoc( mysqli_query($simpleconnection, "SELECT get_num_songs_album(".$row2['album_ID'].") AS n;")); 
                		$numSongs = "Songs: "+ $test['n'];
                		$categ = mysqli_fetch_assoc( mysqli_query($simpleconnection, "SELECT category, name FROM album WHERE album_ID=".$row2['album_ID'].";"));
                		$categories = "Category: ".$categ['category'];
                		$title = $categ['name'];
                	}
                }
                $comments =mysqli_query($simpleconnection, "SELECT * FROM comment WHERE ID = ".$row2['followed_ID']." AND post_date = '".$row2['post_date']."';");
                $queryRes =mysqli_fetch_assoc( mysqli_query($simpleconnection, "SELECT username from user WHERE ID='".$row2['followed_ID']."';"));
                $poster = mysqli_query($simpleconnection, "SELECT first_name, last_name FROM user WHERE ID = ".$row2['followed_ID'].";");
				$pp = mysqli_fetch_assoc($poster);
				$namePoster = $pp['first_name'];
				$surnamePoster = $pp['last_name'];
				$argument = $row2['followed_ID'].",'".$row2['post_date']."'";	
				$getLikes3 = mysqli_query($simpleconnection, "SELECT get_post_likes(".$argument.") AS n;");
				$numLikes3 = mysqli_fetch_assoc($getLikes3);
                echo "
					<div class=\"panel panel-default panel-transparent\" style=\"width:60%; margin-left:20%;\">
						<div class=\"panel-body\">
							<div class=\"media\">		
								<div class=\"media-left\">	
									<img src=\"images/".$row2['followed_ID'].".jpg\" class=\"media-object\" style=\"width:45px\">
								</div>
								<div class=\"media-body\">
									<h4 class=\"media-heading\">".$namePoster." ".$surnamePoster." <small><i>Posted on ".$row2['post_date']."</i></small></h4>
								</div>
							</div>
						</div>
						<div class=\"panel panel-default panel-transparent\" style=\"margin-top:.5%;\">
							<div class=\"panel-body\">
								<div class=\"comment\">
									<h4>".$row2['texti']."</h4>
								</div>
							</div>
						</div>
						<div class=\"panel panel-default panel-transparent\" style=\"margin-top:.5%;\">
							<div class=\"panel-body\">
								<div class=\"playlist-name\">
									<div class=\"rows\">
										<h4>".$title."</h4>
									</div>
								</div>
								<div class=\"playlist-img\">
									<div class=\"rows\" align=\"center\">
										<img src=\"images/".$defaultImg.".jpg\"/>
									</div>
								</div>
								<div class=\"playlist-name\">
									<div class=\"rows\">
										<div class=\"col-sm-3\">
											<h4>".$numSongs."</h4>
										</div>
										<div class=\"col-sm-7\" align=\"right\">
											<h4>".$categories."</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class=\"panel panel-default panel-transparent\" style=\"margin-top:.5%;\">
							<div class=\"panel-body\">
								<div class=\"playlist-name\">
									<div class=\"rows\" align=\"left\">
										<div class=\"media\">	
											<div class=\"media-left\" style=\"color:#2d7eff; font-size:18px;\" id=\"divInput".$argument."\">
												<p><b>".$numLikes3['n']."</b></p>
											</div>	
											<div class=\"media-left\">	
												<input onclick=\"showHint(this.id, 3)\" id=\"".$argument."\" name=\"postLike\" type=\"image\" src=\"images\like.png\" class=\"media-object\" style=\"width:48px\"/>
											</div>
											<div class=\"media-left\" style=\"color:#2d7eff; font-size:18px;\" id=\"divInput\">
												<p><b>0</b></p>
											</div>
											<div class=\"media-body\">
												<input onclick=\"showHint(this.id, 2)\" id=\"\" name=\"repLike\" type=\"image\" src=\"images\comment-icon.png\" class=\"media-object\" style=\"width:48px\"/>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class=\"panel panel-default panel-transparent\" style=\"margin-top:.5%;\">
							<div class=\"panel-body pre-scrollable\" style=\"height:250px;\">";
								$in2 = false;
        						while($row3 = mysqli_fetch_assoc($comments)) {
        							$commenter = mysqli_query($simpleconnection, "SELECT first_name, last_name FROM user WHERE ID = ".$row3['commenter_ID'].";");
        							$commenter2 = mysqli_fetch_assoc($commenter);
        							$name = $commenter2['first_name'];
        							$surname = $commenter2['last_name'];
                					$in2 = true;
                					echo " 
									<div class=\"media\">		
										<div class=\"media-left\">	
											<img src=\"images/".$row3['commenter_ID'].".jpg\" class=\"media-object\" style=\"width:45px\">
										</div>
										<div class=\"media-body\">
											<h4 class=\"media-heading\">".$name." ".$surname." <small><i>Posted on ".$row3['comment_date']."</i></small></h4>
											<p>".$row3['texti']."</p>";
											$in3 = false;
											$repplies = mysqli_query($simpleconnection, "SELECT * FROM reply WHERE ID = ".$row3['ID']." AND commenter_ID = '".$row3['commenter_ID']."' AND post_date = '".$row3['post_date']."' AND comment_date = '".$row3['comment_date']."';");
											$arg2 = $row3['ID'].",'".$row3['post_date']."',".$row3['commenter_ID'].",'".$row3['comment_date']."'";	
											$getLikes2 = mysqli_query($simpleconnection, "SELECT get_comment_likes(".$arg2.") AS n;");
											$numLikes2 = mysqli_fetch_assoc($getLikes2);
        									while($row4 = mysqli_fetch_assoc($repplies)) {
        										$commenter3 = mysqli_query($simpleconnection, "SELECT first_name, last_name FROM user WHERE ID = ".$row4['commenter_ID'].";");
        										$commenter4 = mysqli_fetch_assoc($commenter3);
        										$name2 = $commenter4['first_name'];
        										$surname2 = $commenter4['last_name'];
                								$in3 = true;				
                								echo " 
                								<div class=\"media\">
    												<div class=\"media-left\">
      													<img src=\"images/".$row4['commenter_ID'].".jpg\" class=\"media-object\" style=\"width:45px\"/>
	    											</div>
    												<div class=\"media-body\">
      													<h4 class=\"media-heading\">".$name2." ".$surname2." <small><i>Posted on ".$row4['comment_date']."</i></small></h4>
      													<p>".$row4['text']."</p>
      												</div>
      												<div class=\"media-right\">";
      													$arg = "'".$row4['comment_date']."',".$row4['ID'].",".$row4['commenter_ID'].",'".$row4['post_date']."','".$row4['reply_date']."',".$row4['replier_ID'];
      													$getLikes = mysqli_query($simpleconnection, "SELECT get_reply_likes(".$arg.") AS n;");
														$numLikes = mysqli_fetch_assoc($getLikes);
      													echo "
              											<input onclick=\"showHint(this.id, 2)\" id=\"".$arg."\" name=\"repLike\" type=\"image\" src=\"images\like.png\" class=\"media-object\" style=\"width:28px\"/>
	            									</div>
    	  											<div class=\"media-right\" style=\"color:#2d7eff; font-size:18px;\" id=\"divInput".$arg."\">
      													<p><b></b>".$numLikes['n']."</p>
      												</div>
	      										</div>";
											}
										echo 
										"</div>
										<div class=\"media-right\">
          									<input onclick=\"showHint(this.id, 1)\" id=\"".$arg2."\" name=\"repComm\" type=\"image\" src=\"images\like.png\" class=\"media-object\" style=\"width:28px\">
          									<div class=\"media-right\" style=\"color:#2d7eff; font-size:18px;\" id=\"divInput".$arg2."\">
      											<p><b></b>".$numLikes2['n']."</p>
  											</div>
            							</div>
            						</div>";
								}
								if(!$in2)
                				echo "<h3>*NO COMMENT*</h3>";
                				echo "
                				<div class=\"media\" style=\"display:none\" id=\"newComment".$argument."\">		
									<div class=\"media-left\">	
										<img src=\"images/".$_SESSION['cid'].".jpg\" class=\"media-object\" style=\"width:45px\">
									</div>
									<div class=\"media-body\">
										<h4 class=\"media-heading\">".$myname." ".$mysurname." <small><i>Posted on NOW</i></small></h4>
										<div id=\"newComm".$argument."\"><p></p>
									</div>
								</div>
							</div>
						</div>    
						<div class=\"panel panel-default panel-transparent\" style=\"margin-top:.5%;\">
							<div class=\"panel-body\">
								<table id=\"myTable\" class=\" table order-list\">
									<tbody>
										<tr>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<td colspan=\"5\" style=\"text-align: left;\">
												<div align=\"right\">
													<input type=\"textarea\" class=\"form-control\"  id=\"focusedInput".$row2['followed_ID']."'".$row2['post_date']."'\" type=\"text\" placeholder=\"Leave a comment...\" name=\"postText\"/>";
													$abc = $row2['post_date'];
													echo "<input onclick=\"makeComment( this.id,".$_SESSION['cid'].",'$abc')\" id=\"".$row2['followed_ID']."\" class=\"btn btn-success btn-lg\"  value=\"Post Comment\" name=\"postcomment\"/>
												</div>
											</td>
										</tr>
										<tr>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
				<hr/>";
			}if(!$in)
                echo "<li ><h3>Unfortunately you don't have any post!</h3></li>";
        ?>
	</div>
	<script>
		$(document).ready(function(){
		  $("#myInput").on("keyup", function() {
		    var value = $(this).val().toLowerCase();
		    $("#myDIV *").filter(function() {
		      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		    });
		  });
		});
	</script>
	<script type="text/javascript">
		function showHint(j, from) {
			//	alert(str);
	        var xmlhttp = new XMLHttpRequest();
	        var inputID = "divInput"+j;
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	            		document.getElementById(inputID).innerHTML = this.responseText;
	            }
	        };
	        if (from == 1)
	        	xmlhttp.open("GET", "updateLikes.php?q=1&t="+j, false); 
	        if (from == 2)
	        	xmlhttp.open("GET", "updateLikes.php?q=2&t="+j, false);
	        if (from == 3)
	        	xmlhttp.open("GET", "updateLikes.php?q=3&t="+j, false);
	        xmlhttp.send();
		};
	</script>
	<script type="text/javascript">
			
		function checkVals() {
			document.getElementById("postForm").submit();

		}
	</script>
	<script type="text/javascript">
		function makeComment(ID, commenter_ID, post_date) {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

            alert("done");
            var inputID = "newComment"+ID+",'"+post_date+"'";
            alert(inputID);
            alert("done2");
        	var input2 = "newComm"+ID+",'"+post_date+"'";
        	alert(input2);
        	alert("done3");
          	document.getElementById(inputID).style.display = 'block';
          	alert("done4");
          	var txtVal2 = document.getElementById(textID).value;
          	document.getElementById(input2).innerHTML = txtVal2;
          	var input3 = "toBeRemoved"+ID+",'"+post_date+"'";
          	document.getElementById(input3).innerHTML = "";
            }
        };
        var textID = "focusedInput"+ID+"'"+post_date+"'";
        var txtVal = document.getElementById(textID).value;
        var arg = ID + "," + commenter_ID + ", NOW(), '" + post_date + "', '"+txtVal+"'";
        xmlhttp.open("GET", "updateLikes.php?q=4&t="+arg, false); 
        xmlhttp.send();
        	
        }
	</script>
</body>
</html>