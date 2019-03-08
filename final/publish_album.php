<?php
	session_start();
	if(isset($_SESSION['album_published_successfuly'])){
		if($_SESSION['album_published_successfuly'] == 1) {
			$published = 1;
			$_SESSION['album_published_successfuly'] = 0 ;
		}else {
			$published = 0;
		}
	}else{
		$published = 0;
	}
	
	$db_servername = "dijkstra.ug.bcc.bilkent.edu.tr";
	$db_username = "rubin.daija";
	$db_password = "sm15dzl";
	$db_database = "rubin_daija";

	// Create connection
	$conn = mysqli_connect($db_servername, $db_username, $db_password, $db_database);
	if (!$conn) {
		//	echo "nOT CONNECTED<br>";
		die("Connection failed: " . mysqli_connect_error());
	}

    $result = $conn->query("SELECT art_name FROM artist;");
    $count = 0;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<p style=\"display:none\" id = \"suggest$count\">". $row["art_name"]. "</p>";
		    $count++;
		}
	}
	echo "<p id = \"num_suggestions\" style=\"display:none\">$count</p>";

	$result = $conn->query("SELECT label_name FROM production_manager;");
    $count = 0;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<p style=\"display:none\" id = \"suggest_label$count\">". $row["label_name"]. "</p>";
		    $count++;
		}
	}
	echo "<p id = \"num_suggestions_label\" style=\"display:none\">$count</p>";

?>
<script type="text/javascript">
	var suggestions = [];
	var sizze = parseInt(document.getElementById("num_suggestions").innerHTML);
	//alert(sizze );
	for (var i = 0; i < sizze; i++){
		suggestions.push(document.getElementById("suggest"+i).innerHTML);
	}

	var suggestions_label = [];
	var sizze = parseInt(document.getElementById("num_suggestions_label").innerHTML);
	//alert(sizze );
	for (var i = 0; i < sizze; i++){
		suggestions_label.push(document.getElementById("suggest_label"+i).innerHTML);
	}
</script>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>MUZIKA ~ Publish Album</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- <link rel="stylesheet" href="css/style_index.css">	 -->
	<link rel="icon" href="img/icon.png" type="image/png" size="16x16"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type='text/javascript' src='auto_complete.js'></script>

</head> 
<body style="background-image: url('images/bg.png'); background-attachment: fixed;" >
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



<div class="playlist-info" >
	<div class="container" id ="container_id" style="width:60%;">
	
		<div class="alert alert-success alert-dismissable" id="alert_box_success" style="display:none; width: 60%; height: 12%; margin-top:-1%;margin-left: -1%; position: absolute;  background:rgba(55,255,0,0.9)">
						<a class="close" onclick="$('#alert_box_success').hide()"  style="color:#000; opacity: 0.4">×</a>  
						<strong style="color: #085600; font-size: 20pt;" >Album added successfully!</strong>
		</div>
		<script type="text/javascript">
			$("#alert_box_success").fadeTo(2000, 500).slideUp(500, function(){
			    $("#alert_box_success").slideUp(500);
			});
			document.getElementById("alert_box_success").style.display = "none";

		</script>
		<?php 
			if($published == 1){
				echo "<script type=\"text/javascript\">
					document.getElementById(\"alert_box_success\").style.display = \"block\";
				</script>";
			}else if($published == 0 ){
				echo "<script type=\"text/javascript\">
					document.getElementById(\"alert_box_success\").style.display = \"none\";
			</script>";
			}
		?>

		<h1>Publish an album</h1>
		<div class="panel panel-default panel-transparent" >
			<div class="panel-heading"><h4>Please Fill Album Information</h4></div>

			<div class="panel-body">

				<div class="alert alert-danger alert-dismissable" id="alert_box" style="display: none; background:rgba(247,79,79,0.9);width: 57.5%; margin-top:-1%;margin-left: -1%; position: absolute;z-index: 1000 ">
					<a class="close" onclick="$('#alert_box').hide()"  style="color:#000; opacity: 0.4">×</a>  
					<strong style="color: white; font-size: 12pt;" id="warning_album">Warning!</strong>
				</div>

				<form class="form-horizontal" id="form1" action="insert_album.php">
					<div class="form-group">
						<label class="col-sm-2 control-label" style="font-size: 14px;">Name</label>
						<div class="col-sm-10">
							<input class="form-control" name = "albumName" id="albumName_input"   type="text" value="Name...">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" style="font-size: 14px;">Category</label>
						<div class="col-sm-10">
							<input class="form-control" id="albumCategory_input" name = "albumCategory"  type="text" value="Enter category...">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" style="font-size: 14px;">Price</label>
						<div class="col-sm-10">
							<input class="form-control" id="albumPrice_input"  name = "albumPrice"  type="text" value="Enter album price...">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" style="font-size: 14px;">Manager Label</label>
						<div class="col-sm-10">
							<input class="form-control" id="albumManagerLabel_input" name = "albumManagerLabel"  type="text" value="Write your label...">
						</div>
					</div>
					<div align="right">
						<button type="button" onclick="saveAlbumInfo()" class="btn btn-success btn-lg" style=" " value="Complete" name="complete" id="save_album_info_id" >SAVE</button>
					</div>
				</form>
			</div>
		</div>

		<div class="panel panel-default panel-transparent"  id = "song_panel" style="display: none; ">
			<div class="panel-heading"  >
				<h4>Please fill song information:</h4>
			</div>
			<div class="panel-body" id = "p_body">
				<div class="alert alert-danger alert-dismissable" id="alert_box_song" style="display: none; background:rgba(247,79,79,0.9);width: 57.5%; margin-top:-1.1%;margin-left: -1.1%; position: absolute;z-index: 1000 ">
					<<a class="close" onclick="$('#alert_box_song').hide()"  style="color:#000; opacity: 0.4">×</a>  
					<strong style="color: white; font-size: 12pt;" id="warning_song">Warning!</strong>
				</div>
				<form class="form-horizontal"  >		
					<div class="form-group">
						<label class="col-sm-2 control-label" style="font-size: 14px;">Name</label>
						<div class="col-sm-10">
							<input  style="width: 70%; margin-left: 5%" class="form-control" id="nameInput"   onfocus= "this.value=''"; type="text" value="Name...">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" style="font-size: 14px;">Price</label>
						<div class="col-sm-10">
							<input  style="width: 70%; margin-left: 5%" class="form-control" id="priceInput"  onfocus= "this.value=''"; type="text" value="Enter song price...">
						</div>
					</div>
					<!-- <div class="form-group">
						<label class="col-sm-2 control-label" style="font-size: 14px;">Producer</label>
						<div class="col-sm-10">
							<input  style="width: 70%; margin-left: 5%" class="form-control" id="producerInput"  onfocus= "this.value=''";  type="text" value="Enter producer name...">
						</div>
					</div> -->
					<div class="form-group">
						<label class="col-sm-2 control-label" style="font-size: 14px;">Lyrics</label>
						<div class="col-sm-10">
							<input  style="width: 70%; margin-left: 5%"  class="form-control" id="lyricsInput"  onfocus= "this.value=''";  type="text" value="Write the songs lyrics...">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" style="font-size: 14px;">Genre</label>
						<div class="col-sm-10">
							<input  style="width: 70%; margin-left: 5%"  class="form-control" id="genreInput"  onfocus= "this.value=''";  type="text" value="Write your genre...">
						</div>
					</div>


					<table id="myTable" class="table order-list">
						<tbody>
							<tr >
								<td style="width: 20%;">  
									<label class="col-sm-2 control-label" style="font-size: 14px; width: 70%;">Co-artist</label>
								</td>
								<td class="col-sm-8" style="width: 20%">
									<input type="text" name="co_artist_1" id = "co_artist_1" class="form-control" value=""  onfocus= "this.value=''";  />
								</td>

								<td style="width: 17%; padding-left: 9%">  
									<label class="col-sm-2 control-label" style="font-size: 14px; width: 70%; ">Role</label>
								</td>
								<td class="col-sm-8" style="width: 20%">
									<input type="text" name="role_1" class="form-control" value=""  onfocus= "this.value=''";  />
								</td>
								<td class="col-sm-8" style="width: 40%; ">
									<button  type="button" class="btn btn-default" style="float: left; " onclick="addContributor('myTable')" >Add More</button>  
								</td>
								<input type="text" name="num_co_artists" id="num_co_artists"value="" style="display: none">
							</tr>
						</tbody>
					</table>

					<div align="right">
						<button  type="button" class="btn btn-success" style="float: right; padding: 15px 35px; margin-right: 9%;" onclick="saveSong()" >Complete</button>  
					</div>	
				</form>
			</div>
		</div>
	</div>
</div>


<br><br>


<div class="container" align="left" style="width: 65%; margin-left: 14%">
	<form id = "form2" action="insert_album.php"   method="post"> 
		<div class="row" id= "container_ids" style="float: left;">
			<h2 id="h2_txt" style="display: none">Songs to be added </h2>
		</div>
		<br>
		<button  type="button" class="btn btn-success" id="submit_btn" style="display:none; float: right; padding: 10px 30px; " onclick="submitData()" >Submit</button>
		<button  type="button" class="btn btn-warning" id="cancel_adding_btn" style="display:none; float: right; padding: 10px 30px; margin-right: 10px " onclick="removeTable()">Cancel</button>	
		<input type="text" id = "numSongs" name="num_songs_to_be_added" value="" style ="display: none">
			
			<input style="display: none"  id="the_name" 			name = "albumName"  type="text" value="">
			<input  style="display: none" id="the_category" 		name = "albumCategory"  type="text" value="">
			<input  style="display: none" id="the_price" 			name = "albumPrice"  type="text" value="">
			<input  style="display: none" id="the_manager_label" 	name = "albumManagerLabel"  type="text" value="">
</form>
</div>
<br>
<br>
<br>
<br>
</body>
</html>


<script type="text/javascript">



</script>


<script type="text/javascript">
	var countContributor = 2;
	var numSongs = 0;
	var tables_saved = "tableSaved";
	var alreadyCreated = 0; 
	var tables_tbody;
	var table_el;
	var name_num = 0;
	var rm_btn_arr = [];
	var global_i = 0;
	var num_co_artists = 1;
	var artist_does_not_exist = 0;
	

	autocomplete(document.getElementById("albumManagerLabel_input"), suggestions_label, "35%", "20pt");

	/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
	autocomplete(document.getElementById("co_artist_1"), suggestions, "9.5%");

	function resetMyTableEmptyBoxes(){
		var table = document.getElementById("myTable");
		for(var i = 0; i < num_co_artists; i++){
			if (table.rows[i].cells[1].children[0] !== null){
				table.rows[i].cells[1].children[0].style.backgroundColor = "white";
				table.rows[i].cells[1].children[0].style.color = "#707070";
			}if (table.rows[i].cells[3].children[0] !== null){
				table.rows[i].cells[3].children[0].style.backgroundColor = "white";
				table.rows[i].cells[3].children[0].style.color = "#707070";
			}
		}
	}

	function checkMyTableEmptyBoxes(){
		var table = document.getElementById("myTable");
		var a = true;
		var only_Int = false;
		var exists = 0;
		if( document.getElementById("nameInput").value === '' ){
			document.getElementById("nameInput").style.backgroundColor =  "#f26565";
			document.getElementById("nameInput").style.borderRadius =  "3px";
			document.getElementById("nameInput").style.padding = "0px 0px 0px 12px";
			document.getElementById("nameInput").style.color =  "white"; a = false;
		}if( document.getElementById("priceInput").value == '' ){
			document.getElementById("priceInput").style.backgroundColor =  "#f26565";
			document.getElementById("priceInput").style.borderRadius =  "3px";
			document.getElementById("priceInput").style.padding = "0px 0px 0px 12px";
			document.getElementById("priceInput").style.color =  "white"; a = false;
		}if(isNaN(document.getElementById("priceInput").value)  && (document.getElementById("albumPrice_input").value !== '')){
			document.getElementById("priceInput").style.backgroundColor =  "#ffa921";
			document.getElementById("priceInput").style.borderRadius =  "3px";
			document.getElementById("priceInput").style.padding = "0px 0px 0px 12px";
			document.getElementById("priceInput").style.color =  "white"; a = false;
			$("#alert_box_song").delay(50).fadeIn("slow","swing"); 
			document.getElementById("warning_song").innerHTML = "Field price should be a number";
		}if( document.getElementById("lyricsInput").value === '' ){
			document.getElementById("lyricsInput").style.backgroundColor =  "#f26565";
			document.getElementById("lyricsInput").style.borderRadius =  "3px";
			document.getElementById("lyricsInput").style.padding = "0px 0px 0px 12px";
			document.getElementById("lyricsInput").style.color =  "white"; a = false;
		}if( document.getElementById("genreInput").value === '' ){
			document.getElementById("genreInput").style.backgroundColor =  "#f26565";
			document.getElementById("genreInput").style.borderRadius =  "3px";
			document.getElementById("genreInput").style.padding = "0px 0px 0px 12px";
			document.getElementById("genreInput").style.color =  "white"; a = false;
		}

		for(var i = 0; i < num_co_artists; i++){
			if (i === 0){
				if(table.rows[i].cells[1].children[0].value === '' && table.rows[i].cells[3].children[0].value === '' ){
				}else{
					if(table.rows[i].cells[1].children[0].value === ''){
						table.rows[i].cells[1].children[0].style.backgroundColor = "#f26565";
						table.rows[i].cells[1].children[0].style.borderRadius = "2px";
						table.rows[i].cells[1].children[0].style.padding = "0px 0px 0px 12px";
						table.rows[i].cells[1].children[0].style.color = "white";
						a =  false;
					}if(table.rows[i].cells[3].children[0].value === ''){
						table.rows[i].cells[3].children[0].style.backgroundColor = "#f26565";
						table.rows[i].cells[3].children[0].style.borderRadius = "2px";
						table.rows[i].cells[3].children[0].style.padding = "0px 0px 0px 12px";
						table.rows[i].cells[3].children[0].style.color = "white";
						a =  false;
					}

					for (var k = 0; k < suggestions.length; k++){
						alert("__"+ table.rows[i].cells[1].children[0].value + " = " + suggestions[k] );
						if(table.rows[i].cells[1].children[0].value === suggestions[k]){
							exists = 0;
							break ;
						}
						if (table.rows[i].cells[1].children[0].value !== suggestions[k]){
							exists = 1;
						}
					}
					alert("aaaaaa");
					if(exists){
						artist_does_not_exist = 1;
						a =  false;
						table.rows[i].cells[1].children[0].style.backgroundColor = "#f26565";
						table.rows[i].cells[1].children[0].style.borderRadius = "2px";
						table.rows[i].cells[1].children[0].style.padding = "0px 0px 0px 12px";
						table.rows[i].cells[1].children[0].style.color = "white";
					}
				}
			}else{
				if (table.rows[i].cells[1].children[0] !== null){
					if (table.rows[i].cells[1].children[0].value === ''){
						table.rows[i].cells[1].children[0].style.backgroundColor = "#f26565";
						table.rows[i].cells[1].children[0].style.borderRadius = "2px";
						table.rows[i].cells[1].children[0].style.padding = "0px 0px 0px 12px";
						table.rows[i].cells[1].children[0].style.color = "white";
						a =  false;
					}
					for (var k = 0; k < suggestions.length; k++){
						alert("__"+ table.rows[i].cells[1].children[0].value + " = " + suggestions[k] );
						if(table.rows[i].cells[1].children[0].value === suggestions[k]){
							exists = 0;
							break ;
						}
						if (table.rows[i].cells[1].children[0].value !== suggestions[k]){
							exists = 1;
						}
					}
					alert("aaaaaa");
					if(exists){
						artist_does_not_exist = 1;
						a =  false;
						table.rows[i].cells[1].children[0].style.backgroundColor = "#f26565";
						table.rows[i].cells[1].children[0].style.borderRadius = "2px";
						table.rows[i].cells[1].children[0].style.padding = "0px 0px 0px 12px";
						table.rows[i].cells[1].children[0].style.color = "white";
					}

				}if (table.rows[i].cells[3].children[0] !== null){
					if (table.rows[i].cells[3].children[0].value === ''){
						table.rows[i].cells[3].children[0].style.backgroundColor = "#f26565";
						table.rows[i].cells[3].children[0].style.borderRadius = "2px";
						table.rows[i].cells[3].children[0].style.padding = "0px 0px 0px 12px";
						table.rows[i].cells[3].children[0].style.color = "white";
						a =  false;
					}
				}
			}
		}
		return a;
	}
	function submitData(){

		document.getElementById("form1").submit();
		document.getElementById("form2").submit();
	}



	function addContributor(tableName) {
		var table = document.getElementById(tableName);
		var row = table.insertRow(table.length);	
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);
		var cell3 = row.insertCell(2);
		var cell4 = row.insertCell(3);
		var cell5 = row.insertCell(4);
		num_co_artists++;
		document.getElementById("num_co_artists").value = num_co_artists ;

		cell2.innerHTML = "<input type='text' id='co_artist_"+countContributor+"' name='co_artist_"+countContributor+"'  onfocus= \"this.value=''\";  class='form-control' />";
		cell3.innerHTML = "<label class='col-sm-2 control-label' style='font-size: 14px; width: 70%;' ></label>";
		cell4.innerHTML = "<input  type='text' name='role_"+ (countContributor) +"'  onfocus= \"this.value=''\";   class='form-control' style='float: right' />";
		cell5.innerHTML = "<button  type='button' id='remove'  class='btn btn-warning' style='float: left;' >Remove</button>";
		alert("in between__ " + "co_artist_"+countContributor );
		autocomplete(document.getElementById("co_artist_"+countContributor), suggestions);
		countContributor++;
	}	

	function deleteContributor() {
		var tb = document.getElementById("myTable");
		tb.deleteRow(countContributor-1);
		countContributor--;
	}
	function returnInputElements(){
		var inputArray = new Array(6);	
		for(var i = 0; i < 6; i++){
			inputArray[i] = document.createElement('input');
			inputArray[i].type ="text";
			inputArray[i].style.border =  "0px solid transparent";
			inputArray[i].style.backgroundColor =  "transparent";
			inputArray[i].style.width =  "90%";
			inputArray[i].maxLength = 20;	
			inputArray[i].value = "";
		}
		inputArray[0].name = "nameInput" +name_num;
		inputArray[0].readOnly = true;
		inputArray[0].value = document.getElementById('nameInput').value;

		inputArray[1].name = "priceInput"+ name_num;
		inputArray[1].readOnly = true;	
		inputArray[1].value = document.getElementById('priceInput').value;

		inputArray[2].name = "lyricsInput"+name_num;
		inputArray[2].readOnly = true;
		inputArray[2].value = document.getElementById('lyricsInput').value;

		inputArray[3].name = "genreInput"+name_num;
		inputArray[3].readOnly = true;
		inputArray[3].value = document.getElementById('genreInput').value;

		inputArray[4].name = "coArtistInput" + name_num;
		inputArray[4].readOnly = true;
		inputArray[4].value = retrieveNonParsedText(document.getElementById("myTable"));

		name_num++;
		return inputArray;
	}


	function retrieveNonParsedText(x){
		var string = "";
		for (var i = 0; i < x.rows.length;  i++) {
			var c = x.rows[i].cells;
			string += c[1].getElementsByTagName('input')[0].value + ":";
			string += c[3].getElementsByTagName('input')[0].value + ":";	
		}
		return string;
	}

	function saveAlbumInfo(){
		var empty = false;
		var only_Int = false;
		var suggestionInvalid = false;
		if( document.getElementById("albumName_input").value === '' ){
			document.getElementById("albumName_input").style.backgroundColor =  "#f26565";
			document.getElementById("albumName_input").style.borderRadius =  "3px";
			document.getElementById("albumName_input").style.padding = "0px 0px 0px 12px";
			document.getElementById("albumName_input").style.color =  "white"; empty = true;
		}if( document.getElementById("albumPrice_input").value == '' ){
			document.getElementById("albumPrice_input").style.backgroundColor =  "#f26565";
			document.getElementById("albumPrice_input").style.borderRadius =  "3px";
			document.getElementById("albumPrice_input").style.padding = "0px 0px 0px 12px";
			document.getElementById("albumPrice_input").style.color =  "white"; empty = true;
		}if(isNaN(document.getElementById("albumPrice_input").value)  && (document.getElementById("albumPrice_input").value !== '')){
			document.getElementById("albumPrice_input").style.backgroundColor =  "#ffa921";
			document.getElementById("albumPrice_input").style.borderRadius =  "3px";
			document.getElementById("albumPrice_input").style.padding = "0px 0px 0px 12px";
			document.getElementById("albumPrice_input").style.color =  "white"; 
			only_Int = true;
		}if( document.getElementById("albumCategory_input").value === '' ){
			document.getElementById("albumCategory_input").style.backgroundColor =  "#f26565";
			document.getElementById("albumCategory_input").style.borderRadius =  "3px";
			document.getElementById("albumCategory_input").style.padding = "0px 0px 0px 12px";
			document.getElementById("albumCategory_input").style.color =  "white"; empty = true;
		}if( document.getElementById("albumManagerLabel_input").value === '' ){
			document.getElementById("albumManagerLabel_input").style.backgroundColor =  "#f26565";
			document.getElementById("albumManagerLabel_input").style.borderRadius =  "3px";
			document.getElementById("albumManagerLabel_input").style.padding = "0px 0px 0px 12px";
			document.getElementById("albumManagerLabel_input").style.color =  "white"; empty = true;
		}
		for (var i = 0; i < suggestions_label.length; i ++){
	 		if(document.getElementById("albumManagerLabel_input").value === suggestions_label[i]){
	 			suggestionInvalid = false;
	 			break;
	 		}
	 		suggestionInvalid = true;
		 }
		 if(suggestionInvalid){
		 	document.getElementById("albumManagerLabel_input").style.backgroundColor =  "#f26565";
			document.getElementById("albumManagerLabel_input").style.borderRadius =  "3px";
			document.getElementById("albumManagerLabel_input").style.padding = "0px 0px 0px 12px";
			document.getElementById("albumManagerLabel_input").style.color =  "white"; 
		 }
		if(empty || only_Int || suggestionInvalid){
			if(only_Int){
				$("#alert_box").delay(50).fadeIn("slow","swing"); 
				document.getElementById("warning_album").innerHTML = "The price field must be an integer";
			}if(empty){
				$("#alert_box").delay(50).fadeIn("slow","swing"); 
				document.getElementById("warning_album").innerHTML = "You have empty boxes in the fields shown in red";
			}if(suggestionInvalid){
				$("#alert_box").delay(50).fadeIn("slow","swing"); 
				document.getElementById("warning_album").innerHTML = "You have entered an invalid Manager Label";
			}
		}else {
			document.getElementById("albumName_input").readOnly = true;
			document.getElementById("albumPrice_input").readOnly = true;
			document.getElementById("albumCategory_input").readOnly = true;
			document.getElementById("albumManagerLabel_input").readOnly = true;
			if(document.getElementById("save_album_info_id").className == "btn btn-default" ){
				document.getElementById("save_album_info_id").className = "btn btn-success";
				document.getElementById("save_album_info_id").innerHTML = "Save";
				document.getElementById("albumName_input").readOnly = false;
				document.getElementById("albumPrice_input").readOnly = false;
				document.getElementById("albumCategory_input").readOnly = false;
				document.getElementById("albumManagerLabel_input").readOnly = false;
				document.getElementById("albumName_input").style.backgroundColor =  "white";
				document.getElementById("albumPrice_input").style.backgroundColor =  "white";
				document.getElementById("albumCategory_input").style.backgroundColor =  "white";
				document.getElementById("albumManagerLabel_input").style.backgroundColor =  "white";
				document.getElementById("song_panel").style.display = "none";
				removeTable();
			}else{
				document.getElementById("the_name").value = document.getElementById("albumName_input").value;
				document.getElementById("the_category").value = document.getElementById("albumCategory_input").value;
				document.getElementById("the_price").value = document.getElementById("albumPrice_input").value;
				document.getElementById("the_manager_label").value = document.getElementById("albumManagerLabel_input").value;
				document.getElementById("save_album_info_id").className = "btn btn-default";
				document.getElementById("save_album_info_id").innerHTML = "Edit";
				document.getElementById("albumName_input").style.backgroundColor =  "transparent";
				document.getElementById("albumPrice_input").style.backgroundColor =  "transparent";
				document.getElementById("albumCategory_input").style.backgroundColor =  "transparent";
				document.getElementById("albumManagerLabel_input").style.backgroundColor =  "transparent";
				document.getElementById("albumName_input").style.color =  "#707070";
				document.getElementById("albumPrice_input").style.color =  "#707070";
				document.getElementById("albumCategory_input").style.color =  "#707070";
				document.getElementById("albumManagerLabel_input").style.color =  "#707070";
				$("#alert_box").hide(); 
				$("#song_panel").delay(399).fadeIn("slow","swing"); 
				setTimeout(function() { 
					document.getElementById("song_panel").scrollIntoView({block: "start", behavior: "smooth"});
				}, 400);

			} 
		}                  
	}

	function all_fields_filled(){
		var allElements = new Array(9);
		var boolean = true;

	}

	// take all info from the input fields and create a table with it
	function saveSong() {
		var chckd = false;

		if(checkMyTableEmptyBoxes()){
			if ( alreadyCreated === 0  || table_el === null){
				if(table_el === null){
					chckd = true;
				}
				table_el = document.createElement("table");

				table_el.setAttribute('class', 'table table-hover');
				table_el.style.cssFloat = "left" ;
				table_el.setAttribute('id', tables_saved);
				tables_tbody = document.createElement("tbody");

				var header = table_el.createTHead();
				var row = header.insertRow(0);

				var cell  = row.insertCell(0);	
				var cell1 = row.insertCell(1);
				var cell2 = row.insertCell(2);
				var cell3 = row.insertCell(3);
				var cell4 = row.insertCell(4);
				var cell5 = row.insertCell(5);

				cell.innerHTML = "<b>Name</b>";
				cell1.innerHTML = "<b>Price</b>";
				cell2.innerHTML = "<b>Lyrics</b>";
				cell3.innerHTML = "<b>Genre</b>";
				cell4.innerHTML = "<b>Co-artist</b>";

				//cell3.style.display = "none";
			}else if (alreadyCreated === 1){
				table_el.style.display = "block";
			}
			var tr  = document.createElement('tr');

			var td1 = document.createElement('td');
			var td2 = document.createElement('td');
			var td3 = document.createElement('td');
			var td4 = document.createElement('td');
			var td5 = document.createElement('td');

			var listOfInputs = returnInputElements();

			var text5 = retrieveNonParsedText(document.getElementById("myTable"));
		
			td1.appendChild(listOfInputs[0]);
			td2.appendChild(listOfInputs[1]);
			td3.appendChild(listOfInputs[2]);
			td4.appendChild(listOfInputs[3]);
			td5.appendChild(listOfInputs[4]);

				//rowIndexes++;

				tr.appendChild(td1);
				tr.appendChild(td2);
				tr.appendChild(td3);
				tr.appendChild(td4);
				tr.appendChild(td5);

				tables_tbody.appendChild(tr);
				table_el.appendChild(tables_tbody);
				
				if(alreadyCreated === 0  || chckd) {
					document.getElementById("container_ids").appendChild(table_el);
					alreadyCreated = 1;
				}
				tables_saved++;
				document.getElementById ("submit_btn").style.display = "block" ; 
				document.getElementById ("h2_txt").style.display = "block" ; 
				document.getElementById ("cancel_adding_btn").style.display = "block" ; 

				var elmnt = document.getElementById("submit_btn" );
				elmnt.scrollIntoView({block: "start", behavior: "smooth"});
				numSongs++;
				document.getElementById("numSongs").value = numSongs +"";
		   // alert(document.getElementById("numSongs").value);
		   document.getElementById("nameInput").style.backgroundColor =  "white";
		   document.getElementById("priceInput").style.backgroundColor =  "white";
		   document.getElementById("lyricsInput").style.backgroundColor =  "white";
		   document.getElementById("genreInput").style.backgroundColor =  "white";
		   document.getElementById("nameInput").style.color =  "#707070";
		   document.getElementById("priceInput").style.color =  "#707070";
		   document.getElementById("lyricsInput").style.color =  "#707070";
		   document.getElementById("genreInput").style.color =  "#707070";
		   resetMyTableEmptyBoxes();
		   $("#alert_box_song").hide();
		}else{
			if(artist_does_not_exist){
				$("#alert_box_song").delay(50).fadeIn("slow","swing"); 
				document.getElementById("warning_song").innerHTML = "Please fill in a valid Co-Artist name";
				artist_does_not_exist = 0;
			}else{
				$("#alert_box_song").delay(50).fadeIn("slow","swing"); 
				document.getElementById("warning_song").innerHTML = "Please fill in the boxes correctly";
			}	
		}
	}

	//removes all content of table, user
	function removeTable(){		
		if(table_el !== null){
			for(var i = table_el.rows.length - 1; i > 0; i--){
				table_el.deleteRow(i);
			}
			document.getElementById ("submit_btn").style.display = "none" ; 
			document.getElementById ("h2_txt").style.display = "none" ; 
			document.getElementById ("cancel_adding_btn").style.display = "none" ; 
			table_el.style.display = "none" ; 
			numSongs = 0;
			table_el = null;
		}
	}

	function addMoreSongs(){

	}

	// function removeSongs() {
	// 	var elementID =  "fill_song" + (numSongs-1);
	// 	var prev_elementID =  "fill_song" + (numSongs-2);
	// 	if(numSongs == 2 ){
	// 		prev_elementID = "fill_song";
	// 	}
	
	// 	var element = document.getElementById(elementID);
	// 	element.parentNode.removeChild(element);

	// 	var elmnt = document.getElementById(prev_elementID);
 //   		elmnt.scrollIntoView({block: "start", behavior: "smooth"});
 //   		if(numSongs == 2)
	//     	document.getElementById ("remove_more_id").style.display = "none" ; 
	//  	numSongs--;
	// }
</script>


<script type="text/javascript">
	$('#myTable').on('click', 'button[id="remove"]', function(e){
		$(this).closest('tr').remove();
		num_co_artists--;
	})


	$(document).ready(function(){
		$("#myInput").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#myDIV *").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
	});

</script>
