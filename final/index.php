<!DOCTYPE html>
<html lang="en">
	<head>
		<title>MUZIKA</title>
		<?php
			session_start();
			$connection = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","rubin.daija","sm15dzl","rubin_daija");
			if(!$connection)
				echo "Connection not successful!";
			
			if(isset($_SESSION['cid']) && $_SESSION['cid']!=-1){
				header('Location: newsfeed.php');
			}
		?>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/style_index.css">	
		<link rel="icon" href="images/icon.png" type="image/png" size="16x16"/>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
            href="index.php">Home</a>
        </li>

       

    </ul>
</div>
</nav>
		<div class="container">
			<div style="margin-top:10%; margin-left:-10%;">
				<div class="rows">
					<img src="images/MUZIKA.png" style="margin-top:-20%;"/>
					<img src="images/music-splash.png"/>
				</div>
				<div class="rows">
					<div align="left" class="demo" style="width: 350px; height: 100px; z-index: 15; margin-top: -20%; margin-left: 15%;">
						<div class="login">
							<div class="login__form">
								<form method="POST" action="./index.php">
									<div class="login__row">
										<div  style=" width: 100%;">
											<div class="alert alert-warning alert-dismissible fade in" name="show" style="visibility: hidden;">
												<?php

												if(isset($_POST['login'])){
													if( isset($_POST['un']) && isset($_POST['pw']) && isset($_POST['role']) && !empty($_POST['un'])  && !empty($_POST['pw']) && !empty($_POST['role'])){
														$res = mysqli_query($connection,"SELECT ID FROM user WHERE username='"
															.$_POST['un']."' AND password='"
															.$_POST['pw']."'");

														$row = mysqli_fetch_row(mysqli_query($connection,"SELECT ID FROM user WHERE username='"
															.$_POST['un']."' AND password='"
															.$_POST['pw']."'"));

														if( $res->num_rows == 1 ) {
															$_SESSION['cid'] = $row[0];
															$_SESSION['role'] = $_POST['role'];
															header('Location: newsfeed.php');
														}
														else{
															echo "<script>$(\"div[name='show']\").css('visibility','visible')</script> 
																<a class=\"close\" data-dismiss=\"alert\">X</a>
																Username and password do not match!";
														}
														mysqli_close($connection);
													}
													else{
														echo "<script>$(\"div[name='show']\").css('visibility','visible')</script> 
																<a class=\"close\" data-dismiss=\"alert\">X</a>
																All fields should be filled!";
													}
												}
												?>
											</div>
										</div>
									</div>
									<div class="login__row">
										<svg class="login__icon name svg-icon" viewBox="0 0 20 20">
										<path d="M0,20 a10,8 0 0,1 20,0z M10,0 a4,4 0 0,1 0,8 a4,4 0 0,1 0,-8" ></path>
										</svg>
										<input type="text" class="login__input name" name="un" placeholder="Username" id="usrnm"/>
									</div>
									<div class="login__row">
										<svg class="login__icon pass svg-icon" viewBox="0 0 20 20">
										<path d="M0,20 20,20 20,8 0,8z M10,13 10,16z M4,8 a6,8 0 0,1 12,0" ></path>
										</svg>
										<input type="password" name="pw" class="login__input pass" placeholder="Password"/>
									</div>
									<div class="login__row">
										<div class="btn-group" id="rolepicker" data-toggle="buttons">
				                            <label class="btn btn-default blue">
				                                <input type="radio" name="role" class="toggle" value="1">Customer
				                            </label>
				                            <label class="btn btn-default blue">
				                                <input type="radio" name="role" class="toggle" value="2">Artist
				                            </label>
				                            <label class="btn btn-default blue">
				                                <input type="radio" name="role" class="toggle" value="3">Producer
				                            </label>
				                        </div>
				                    </div>
									<div style="margin-left:10%;">	
										<input type="submit" class="btn btn-success btn-lg" style="padding: 15px 32px; margin-left:-8%; margin-top:10%;" value="Sign in" name="login"/>
										<a href="signup.php">
											<button type="button" class="btn btn-info btn-lg" style="padding: 15px 32px; margin-left:10%; margin-top:10%;">Sign Up</button>
										</a>
										<!--<input type="submit" class="login__submit" value="Sign in" name="login"/>-->
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>