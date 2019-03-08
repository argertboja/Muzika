<?php
session_start();
	// if(isset($_SESSION['album_published_successfuly'])){
	// 	if($_SESSION['album_published_successfuly'] == 1) {
	// 		$published = 1;
	// 		$_SESSION['album_published_successfuly'] = 0 ;
	// 	}else {
	// 		$published = 0;
	// 	}
	// }else{
	// 	$published = 0;
	// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>MUZIKA ~ Create Playlist</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/style_index.css">	
    <link rel="icon" href="images/icon.png" type="image/png" size="16x16"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="auto_complete.js"></script>
  	<script type="text/javascript" charset="UTF-8" src="styles/main.js"></script>
	<script type='text/javascript' src='auto_complete.js'></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- <script type='text/javascript' src='js/addrow.js'></script> -->
</head>
<body style="background-image: url('images/bg.png'); background-attachment: fixed;" >
<?php 

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

    $result = $conn->query("SELECT * FROM purchase NATURAL JOIN song WHERE purchase.ID = 1 ");

    $count = 0;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<p style=\"display:none\" id = \"suggest$count\">". $row["name"]. "</p>";
		    $count++;
		}
	}
	echo "<p id = \"num_suggestions\" style=\"display:none\">$count</p>";


?>	
<script type="text/javascript">
	var suggestions = [];
	var sizze = parseInt(document.getElementById("num_suggestions").innerHTML);
	for (var i = 0; i < sizze; i++){
		suggestions.push(document.getElementById("suggest"+i).innerHTML);	
	}	
	//alert("sdsadd");

</script>

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
    <img  style=" color: #fff ;display: block;margin-left: auto;  margin-right: auto; margin-top: 0px "  src="img/icon.png" width="50" height="45"  href="home.php"></img>
  </div>
  <ul class="nav navbar-nav"  >
    <li><a 
      onMouseOver="this.style.color='#268c04'" 
      onMouseOut="this.style.color='#fff'"  
      style=" font-weight: bold;
      font-size:12pt;
      height: 3em; 
      color: #fff; 
      padding-top: 0px; 
      text-align: center; 
      line-height: 3em;"
      href="profile_artist.php">Profile</a>
    </li>

    <li ><a  
  onMouseOver="this.style.color='#268c04'"
      onMouseOut="this.style.color='#fff'"
      style ="color: #fff;
      font-weight: bold;
      font-size:12pt;
      height: 3em; 
      padding-top: 0px;
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
		font-size:12pt;
		height: 3em;
		padding-top: 0px;
		text-align: center;
		line-height: 3em"
		href="search.php">Search</a>
    </li>

    <li><a  onMouseOver="this.style.color='#268c04'" 
      onMouseOut="this.style.color='#fff'" 
      style=" color: #fff; 
      font-weight: bold; 
      font-size:12pt; 
      height: 3em; 
      padding-top: 0px; 
      text-align: center; 
      line-height: 3em" 
      href="post_feed.php">Post Feed</a>
    </li>


    <li class = "active"><a  

		style=" color: #fff; 
		font-weight: bold; 
		font-size:12pt; 
		background-color: #db32db;
		height: 3em; 
		padding-top: 0px; 
		text-align: center; 
		line-height: 3em" 
		href="create_playlist.php">Create Playlist</a>	
    </li>
  <!--   <li><a  onMouseOver="this.style.color='#268c04'" 
      onMouseOut="this.style.color='#fff'" 
      style=" color: #fff; 
      font-weight: bold; 
      font-size:12pt; 
      height: 3em; 
      padding-top: 1px; 
      text-align: center; 
      line-height: 3em" 
      href="profile_manager.php">Profile Manager</a>
    </li> -->
  <!--   <li class="active"> -->

     <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" style="font-size: 12pt;height: 3em; color: #fff;font-weight: bold;  " href="#">More <span class="caret"></span></a>
      <ul class="dropdown-menu ">
        <li><a href="profile_manager.php">Profile Manager</a></li>
        <li><a href="#">Submenu 1-2</a></li>
        <li><a href="#">Submenu 1-3</a></li>                        
      </ul>
    </li>
    <!-- <a   
      style=" color: #fff; 
      font-weight: bold; 
      font-size:12pt; 
      background-color: #db32db;
      height: 4em; 
      padding-top: 1px; 
      text-align: center; 
      line-height: 3em" 
      href="profile_manager.php">Profile Manager</a>
    </li> -->

  </ul>
</div>
</nav>
 

	<div class="playlist-info" >
		<div class="container" style="width:50%;">
			<h1>Create A Playlist</h1>
			<div class="panel panel-default panel-transparent">
				<div class="panel-heading"><h4>Please Fill Playlist Information</h4></div>
				<div class="panel-body">
					<form class="form-horizontal">   
						<div class="form-group">
						  <label class="col-sm-2 control-label" style="font-size: 14px;">Name</label>
						  <div class="col-sm-10">
							<input class="form-control" id="playlistName" type="text" value="Name...">
						  </div>  
						</div>
						<div class="form-group">
						  <label class="col-sm-2 control-label" style="font-size: 14px;">Share State</label>
						  <div class="col-sm-10">
							<!-- <input class="form-control" id="playlistState" type="text" value="Share state..."> -->
							<div class="dropdown">
							  <button class="btn btn-primary dropdown-toggle" type="button" id ="selectorBtn" data-toggle="dropdown">Select option</button>
							  <ul class="dropdown-menu">
							    <li><a href="#" onclick="selectOption('Only Me')" >Only Me</a></li>
							    <li><a href="#" onclick="selectOption('Only My Followers')" >Only My Followers</a></li>
							    <li><a href="#" onclick="selectOption('Public')" >Public</a></li>
							  </ul>
							</div>

						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-2 control-label" style="font-size: 14px;">Description</label>
						  <div class="col-sm-10">
							<input class="form-control" id="playlistDescription" type="text" value="Description...">
						  </div>
						</div>
						<div align="right">
							<input type="button" onclick="savePlaylistInfo()" class="btn btn-success btn-lg" style="padding: 15px 32px; " value="Complete" name="complete"/>
						</div>
					</form>
				</div>
			</div>
			<div class="panel panel-default panel-transparent">
				<div class="panel-heading">
					<h4>Select Songs To Add</h4>
				</div>
				<div class="panel-body">
					<form class="form-horizontal">				
						<table id="myTable" class=" table order-list">
							<tbody>
								<tr>
									<td>
										<label class="col-sm-2 control-label" style="font-size: 14px;">Search</label>
									</td>
									<td class="col-sm-8">
										<input type="text" name="name"  id="searchID" class="form-control" />
									</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="5" style="text-align: left;">
										<div align="right">
											<button type="button" onclick="more_Songs()" class="btn btn-success btn-lg" style="padding: 15px 32px; ">Add Song</button>
										</div>
									</td>
								</tr>
								<tr>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
			</div>
			

			
		</div>
		<div class="container" align="left" style="width: 65%; margin-left: 20%">
			<form id = "form1" action="insert_playlist.php"   method="post"> 
				<div class="row" id= "container_ids" style="float: left; width: 70% ">
						<h2 id="h2_txt" style=" display:none; font-size: 22pt">Songs to be added in the playlist...</h2>
				</div>
			</form>
						<button  type="button" class="btn btn-success" id="submit_btn" style="display: none; float: right; padding: 10px 30px; margin-right: 16%  " onclick="submitData()" >Submit</button>
		<button  type="button" class="btn btn-warning" id="cancel_adding_btn" style="display: none; float: right; padding: 10px 30px; margin-right: 1% " onclick="removeTable()">Cancel</button>	

			
	</div>

			<input type="text" id = "numSongs" name="num_songs_to_be_added" value="55" style ="display: none">
			<input style="display: none"  id="playlistName2" name = "playlistName"  type="text" value="a">
			<input  style="display: none" id="selectorBtn2" 		name = "shareState"  type="text" value="b">
			<input  style="display: none" id="playlistDescription2" 			name = "description"  type="text" value="c">
	</form>
	</div>
<br><br><br>


<script type="text/javascript">
	
	var name_num = 0;
    var alreadyCreated = 0;
    var table_el;
    var numSongs=0;

    function submitData(){
    	alert(document.getElementById("id0").value);
		//document.getElementById("form1").submit();
		document.getElementById("form2").submit();
		if((document.getElementById("id0")) == null){
			alert("null");
		}else {
			alert(document.getElementById("id0").value);
		}
    }

	function returnInputElements(){
		var inputArray = new Array(6);	
		for(var i = 0; i < 2; i++){
			inputArray[i] = document.createElement('input');
			inputArray[i].type ="text";
			inputArray[i].style.border =  "0px solid transparent";
			inputArray[i].style.backgroundColor =  "transparent";
			inputArray[i].style.width =  "90%";
			inputArray[i].style.fontSize =  "12pt";
			inputArray[i].maxLength = 20;	
			inputArray[i].value = "";
		}
		inputArray[0].name = "nameInput" +name_num;
		inputArray[0].readOnly = true;
		inputArray[0].value = document.getElementById('searchID').value;

		inputArray[1].name = "id"+ name_num;
		inputArray[1].setAttribute('id',  "id"+ name_num);
		inputArray[1].readOnly = true;	
		inputArray[1].value = parseInt(retIndex(document.getElementById('searchID').value)) ;
		alert(retIndex(document.getElementById('searchID').value));
		name_num++;
		return inputArray;
	}


	function removeTable(){		
		if(table_el !== null){
			for(var i = table_el.rows.length - 1; i > 0; i--){
				table_el.deleteRow(i);
			}
			document.getElementById("submit_btn").style.display = "none";
			document.getElementById("cancel_adding_btn").style.display = "none";
			document.getElementById ("h2_txt").style.display = "none" ; 

			table_el.style.display = "none" ; 
			numSongs = 0;
			table_el = null;
		}
	
	}
	function more_Songs(){
		var chckd = false;

			if ( alreadyCreated === 0  || table_el === null){
				if(table_el === null){
					chckd = true;
				}
				table_el = document.createElement("table");

				table_el.setAttribute('class', 'table table-hover');

				table_el.style.cssFloat = "left" ;
				table_el.setAttribute('id', "new_table");
				tables_tbody = document.createElement("tbody");

				var header = table_el.createTHead();
				var row = header.insertRow(0);

				var cell  = row.insertCell(0);	
				var cell1 = row.insertCell(1);

				cell.innerHTML = "<b>Song Name</b>";
				cell1.innerHTML = "<b>ID</b>";
				cell.style.fontSize =  "12pt";
				cell.style.display = "none";
				cell1.style.fontSize =  "12pt";
			}else if (alreadyCreated === 1){
				table_el.style.display = "block";
			}
			var tr  = document.createElement('tr');

			var td1 = document.createElement('td');
			var td2 = document.createElement('td');

			var listOfInputs = returnInputElements();

		
			td1.appendChild(listOfInputs[0]);
			td2.appendChild(listOfInputs[1]);

				//rowIndexes++;

				tr.appendChild(td1);
				tr.appendChild(td2);
		
				tables_tbody.appendChild(tr);
				table_el.appendChild(tables_tbody);
				
				if(alreadyCreated === 0  || chckd ) {
					document.getElementById("container_ids").appendChild(table_el);
					alreadyCreated = 1;
				}
				document.getElementById("submit_btn").style.display = "block";
				document.getElementById("cancel_adding_btn").style.display = "block";
				document.getElementById ("h2_txt").style.display = "block" ; 
				//tables_saved++;
				// document.getElementById ("submit_btn").style.display = "block" ; 
				// document.getElementById ("h2_txt").style.display = "block" ; 
				// document.getElementById ("cancel_adding_btn").style.display = "block" ; 

				var elmnt = document.getElementById("submit_btn" );
				 elmnt.scrollIntoView({block: "start", behavior: "smooth"});
				numSongs++;
				document.getElementById("numSongs").value = numSongs +"";

		}
	

	autocomplete(document.getElementById("searchID"), suggestions, "29%","17pt");		


	function selectOption(option){
		if(option === 'Only Me'){
			document.getElementById("selectorBtn").innerHTML = option + " <span class=\"caret\"></span>";
		}else if (option === 'Only My Followers'){
			document.getElementById("selectorBtn").innerHTML = option + " <span class=\"caret\"></span>";
		}else if (option === 'Public'){
			document.getElementById("selectorBtn").innerHTML = option + " <span class=\"caret\"></span>";
		}
	}


	function savePlaylistInfo(){
		var boolean = false;
		if (document.getElementById("playlistName").value ===''){
			document.getElementById("playlistName").style.backgroundColor =  "#f26565";
			document.getElementById("playlistName").style.borderRadius =  "3px";
			document.getElementById("playlistName").style.padding = "0px 0px 0px 12px";
			document.getElementById("playlistName").style.color =  "white";
			boolean = true;
		}if (document.getElementById("selectorBtn").innerHTML ==='Select option'){
			document.getElementById("selectorBtn").style.borderColor =  "#ff0000";
			document.getElementById("selectorBtn").style.borderWidth = "2px";
			boolean = true;
		}if (document.getElementById("playlistDescription").value ===''){
			document.getElementById("playlistDescription").style.backgroundColor =  "#f26565";
			document.getElementById("playlistDescription").style.borderRadius =  "3px";
			document.getElementById("playlistDescription").style.padding = "0px 0px 0px 12px";
			document.getElementById("playlistDescription").style.color =  "white";
			boolean = true;
		}
		if(!boolean){
			document.getElementById("playlistName").setAttribute("disabled", true);
			document.getElementById("selectorBtn").setAttribute("disabled", true);
			document.getElementById("playlistDescription").setAttribute("disabled", true);
			document.getElementById("selectorBtn").style.borderColor =  "#ff0000";
			document.getElementById("selectorBtn").style.borderWidth = "0px";

			document.getElementById("playlistDescription").style.backgroundColor =  "#transparent";
			document.getElementById("playlistDescription").style.borderRadius =  "0px";
			document.getElementById("playlistDescription").style.color =  "#707070";

			document.getElementById("playlistName").style.backgroundColor =  "transparent";
			document.getElementById("playlistName").style.borderRadius =  "0px";
			document.getElementById("playlistName").style.color =  "#707070";

			document.getElementById("playlistName2").value = document.getElementById("playlistName").value;
			// = 	document.getElementById("selectorBtn").innerHTML;
			var str = document.getElementById("selectorBtn").innerHTML;
			document.getElementById("selectorBtn2").value = str.substr(0, str.indexOf('<span')); 
		//	<span
			document.getElementById("playlistDescription2").value = 	document.getElementById("playlistDescription").value;
			//alert(document.getElementById("selectorBtn2").value + "__");

		}else{
			alert("Please fill in the required fields");
		}

	}	
function retIndex( string){
		for (var i = 0; i < sizze; i++){
			if (suggestions[i] === string){
				return i;
			}
		}
	}
</script>
</body>
</html>