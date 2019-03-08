<?php
	session_start();
	$connection = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","rubin.daija","sm15dzl","rubin_daija");
	$var = $_REQUEST["q"];
	$values = $_REQUEST["t"];
	if ($_REQUEST['q'] != 4) { 
		if ($var == 1) {
			if(isset($_SESSION['cid']) && $_SESSION['cid']!=-1){
				$commeLike = mysqli_query($connection, "INSERT INTO comment_likes (creator_ID, post_date, commenter_ID, comment_date, liker_ID) values (".$values.",".$_SESSION['cid'].");"); 
			}
			$getLikes = mysqli_query($connection, "SELECT get_comment_likes(".$values.") AS n;");
		}
		if ($var == 2) { 
			if(isset($_SESSION['cid']) && $_SESSION['cid']!=-1){
					$repLike = mysqli_query($connection, "INSERT INTO reply_likes (comment_date, creator_ID, commenter_ID, post_date, reply_date, replier_ID, liker_ID) values (".$values.",".$_SESSION['cid'].");"); 
			}
			$getLikes = mysqli_query($connection, "SELECT get_reply_likes(".$values.") AS n;");
		}
		if ($var == 3) { 
			if(isset($_SESSION['cid']) && $_SESSION['cid']!=-1){
					$repLike = mysqli_query($connection, "INSERT INTO post_likes (creator_ID, post_date, ID) values (".$values.",".$_SESSION['cid'].");"); 
			}
			$getLikes = mysqli_query($connection, "SELECT get_post_likes(".$values.") AS n;");
		}
		$return = mysqli_fetch_assoc($getLikes);
		echo $return['n'];
	}
	else {
		if(isset($_SESSION['cid']) && $_SESSION['cid']!=-1){
					$repLike = mysqli_query($connection, "INSERT INTO comment (ID, commenter_ID, comment_date, post_date, texti) values (".$values.");"); 
			}
	}
?>