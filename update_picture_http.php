 

	<?php	
	session_start();
	$connection = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","rubin.daija","sm15dzl","rubin_daija");
	$var = $_REQUEST["q"];
	$values = $_REQUEST["t"];
	if ($var == 1) {
		if(isset($_SESSION['cid']) && $_SESSION['cid']!=-1){
			$commeLike = mysqli_query($connection, "INSERT INTO comment_likes (comment_date, creator_ID, commenter_ID, post_date, reply_date) values (".$values.",".$_SESSION['cid'].");"); 
		}
		$getLikes = mysqli_query($connection, "SELECT get_reply_likes(".$values.") AS n;");
	}
	else { 
		if(isset($_SESSION['cid']) && $_SESSION['cid']!=-1){
				$repLike = mysqli_query($connection, "INSERT INTO reply_likes (comment_date, creator_ID, commenter_ID, post_date, reply_date, replier_ID, liker_ID) values (".$values.",".$_SESSION['cid'].");"); 
		}
		$getLikes = mysqli_query($connection, "SELECT get_reply_likes(".$values.") AS n;");
	}
	$return = mysqli_fetch_assoc($getLikes);
	echo $return['n'];
?>