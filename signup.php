<!DOCTYPE html>
<html lang="en">
    <head>
        <title>MUZIKA ~ Sign Up</title>
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript">
            function show1(){
                document.getElementById('art').style.display ='none';
                document.getElementById('label').style.display ='none';
            }
            function show2(){
                document.getElementById('art').style.display ='block';
                document.getElementById('label').style.display ='none';
            }
            function show3(){
                document.getElementById('art').style.display ='none';
                document.getElementById('label').style.display ='block';
            }
        </script>
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
            <div style="margin-top:10%;">
                <div class="rows">
                    <div align="left" class="demo" style="width: 40%; height: 100px; margin-top: -5%;">
                        <div class="signup">
                            <div class="login__form">
                                <form method="POST" action="">
                                    <div class="login__row">
                                        <div  style=" width: 100%;">
                                            <div class="alert alert-warning alert-dismissible fade in" name="show" style="visibility: hidden;">
                                                 <?php  
                                                    if(isset($_POST["signup"])){
                                                        if(isset($_POST['firstname']) && isset($_POST['surname']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repeatpassword']) && isset($_POST['birthdate']) && isset($_POST['gender']) && isset($_POST['type']) && !empty($_POST['firstname'])  && !empty($_POST['surname'] )&& !empty($_POST['username'])  && !empty($_POST['password'] ) && !empty($_POST['repeatpassword'])  && !empty($_POST['birthdate'] ) && !empty($_POST['gender'])  && !empty($_POST['type'] )) {
                                                                
                                                            $firstname=$_POST['firstname'];  
                                                            $secondname=$_POST['surname'];  
                                                            $username=$_POST['username'];  
                                                            $email=$_POST['email'];  
                                                            $password=$_POST['password'];  
                                                            $repeatpassword=$_POST['repeatpassword']; 
                                                            $labelname=$_POST['labelname'];
                                                            $birthdate=$_POST['birthdate'];
                                                            $gender=$_POST['gender'];
                                                            $artistname=$_POST['artistname'];  
                                                            $type=$_POST['type'];
                                                            if ($password == $repeatpassword) {
                                                                $servername = "dijkstra.ug.bcc.bilkent.edu.tr";
                                                                $dbname = "rubin_daija";

                                                              
                                                                $conn=mysqli_connect($servername,'rubin.daija','sm15dzl',$dbname);   

                                                                //check connection
                                                                if (!$conn) {
                                                                    die("Connection failed: " . mysqli_connect_error());
                                                                }

                                                                $sql = "INSERT INTO user VALUES (DEFAULT,'".$firstname."','".$secondname."','".$email."','".$username."','".$password."','no','0','public');";
                                                                $result = mysqli_query($conn,$sql);
                                                                $sql = "SELECT ID FROM user WHERE email LIKE '".$email."';";
                                                                $result = mysqli_query($conn,$sql);
                                                                if(!$result){
                                                                    echo "DAMM SOMETHING IS WRONG";
                                                                }
                                                                $row=mysqli_fetch_assoc($result);
                                                                $id = $row['ID'];
                                                                if($type == "customer"){

                                                                     $sql = "INSERT INTO consumer VALUES ('".$id."','".$gender."','0','".$birthdate."',NOW(),'Hi I am ".$firstname."');";
                                                                }
                                                                else if($type == "artist"){
                                                                    $sql = "INSERT INTO artist VALUES ('".$id."','0','".$artistname."');";
                                                                }
                                                                else{
                                                                    $sql = "INSERT INTO production_manager VALUES ('".$id."','".$labelname."');";

                                                                }      
                                                                $result = mysqli_query($conn,$sql);
                                                                if(!$result){
                                                                    echo "bla bla bla bla bla";
                                                                }
                                                            }
                                                            else{
                                                            echo "<script>$(\"div[name='show']\").css('visibility','visible')</script> 
                                                                    <a class=\"close\" data-dismiss=\"alert\">X</a>
                                                                    Password and Repeat Password do not match!";
                                                        }

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
                                        <input type="text" class="signup__input name" name="firstname" placeholder="Name*" id="name"/>
                                    </div>
                                    <div class="login__row">
                                        <input type="text" class="signup__input name" name="surname" placeholder="Surname*" id="surname"/>
                                    </div>
                                    <div class="login__row">
                                        <input type="text" class="signup__input name" name="username" placeholder="Username*" id="usrnm"/>
                                    </div>
                                    <div class="login__row">
                                        <input type="text" class="signup__input name" name="email" placeholder="Email*" id="email"/>
                                    </div>
                                    <div class="login__row">
                                        <input type="password" name="password" class="signup__input pass" placeholder="Password*"/>
                                    </div>
                                    <div class="login__row">
                                        <input type="password" name="repeatpassword" class="signup__input pass" placeholder="Repeat Password*"/>
                                    </div>
                                    <div class="login__row" align="center">
                                        <div class="form-group" style="width: 60%" >
                                          <select class="form-control" id="sel1" name="gender">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="login__row" >
                                        <input style="height: 25px; width: 250px; font-size:15pt" type="date" name="birthdate">
                                    </div>
                                    <div class="login__row">
                                        <div class="btn-group" id="rolepicker" data-toggle="buttons">
                                            <label class="btn btn-default blue" onclick="show1()" value="1" name="type">
                                                <input type="radio" name="type" class="toggle" value="customer"  />Customer
                                            </label>
                                            <label class="btn btn-default blue" onclick="show2()" value="2" name="type">
                                                <input type="radio" name="type" class="toggle" value="artist" />Artist
                                            </label>
                                            <label class="btn btn-default blue" onclick="show3()" value="3" name="type">
                                                <input type="radio" name="type" class="toggle" value="3" />Producer
                                            </label>
                                        </div>
                                    </div>
                                    <div class="login__row" id="art" style="display: none">
                                        <input type="text" class="signup__input name" name="artistname" placeholder="Artist Name*" id="artistname"/>
                                    </div>
                                    <div class="login__row" id="label" style="display: none">
                                        <input type="text" class="signup__input name" name="labelname" placeholder="Label Name*" id="labelname"/>
                                    </div>
                                    <div style="margin-left:10%;">  
                                        <input type="reset" class="btn btn-danger btn-lg" style="padding: 15px 32px; margin-left:-8%; margin-top:10%;" value="Cancel" name="cancel"/>
                                        <input type="submit" class="btn btn-success btn-lg" style="padding: 15px 32px; margin-left:10%; margin-top:10%;" value="Sign Up" name="signup"/>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div align = "right">
                <img src="images/music-splash.png"/>
            </div>
        </div>

    </body>
</html>