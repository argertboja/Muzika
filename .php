<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <!-- If IE use the latest rendering engine -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Set the page to the width of the device and set the zoon level -->
    <meta name="viewport" content="width = device-width, initial-scale = 1">

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
           
                <div class="well well-sm">
                    <div class="row">
                       
                        <div class="col-sm-6 col-md6">
                            <h1>
                                Personal Information
                            </h1>


                            <div class="row">
                                <div class="col-md-1">
                                    <i class="glyphicon glyphicon-envelope" display: inline-block; style="margin-top:7px; margin-left:7px"></i>
                                </div>
                                <div class="col-md-6" contenteditable="true">
                                    <textarea class="form-control" id="email" style="width:220px; height: 30px; margin-bottom:10px"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                    <i class="glyphicon glyphicon-gift" style="margin-top:7px; margin-left:7px;"></i>
                                </div>
                                <div class="col-md-6" contenteditable="true">
                                    <textarea class="form-control" id="bday" style="width:220px; height: 30px;margin-bottom:10px "></textarea>
                                </div>
                            </div>
                            <p><strong>Member since: </strong> 2015 </p>
                            <div class="row">
                                <div class="col-md-2">
                                    <p><strong>Gender: </strong></p>
                                </div>
                                <div class="col-md-6" contenteditable="true">
                                    <textarea class="form-control" id="gender" style="width:100px; height: 27px;margin-bottom:10px; font-size:11px "></textarea>
                                </div>
                            </div>


                            <div contenteditable="true">
                                <label for="comment">Bio:</label>
                                <textarea class="form-control" rows="4" id="comment"></textarea>
                            </div>
                            <br />
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success btn" style="margin-left:250px"> Update </button>
                            </div>

                        </div>
                        <div class="col-sm-6 col-md-4">
                            <img src="logo.png" style="width: 100px; height: 110px" />
                        </div>
                        <div class="col-xs-12 divider text-center">
                            <div class="col-xs-12 col-sm-4 emphasis">
                                <h2><strong> 20,7K </strong></h2>
                                <p><small>Followers</small></p>
                                <button class="btn btn-success btn-block"><span class="fa fa-plus-circle"></span> See all </button>
                            </div>
                            <div class="col-xs-12 col-sm-4 emphasis">
                                <h2><strong>245</strong></h2>
                                <p><small>Following</small></p>
                                <button class="btn btn-info btn-block"><span class="fa fa-user"></span> See all </button>
                            </div>
                        </div>
                    </div>
                </div>
            
            
            </div>
    </div>


    <div class="col-xs-12 col-sm-4 emphasis">
        <h2><strong>43</strong></h2>
        <p><small>Snippets</small></p>
        <div class="btn-group dropup btn-block">
            <button type="button" class="btn btn-primary"><span class="fa fa-gear"></span> Options </button>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu text-left" role="menu">
                <li><a href="#"><span class="fa fa-envelope pull-right"></span> Send an email </a></li>
                <li><a href="#"><span class="fa fa-list pull-right"></span> Add or remove from a list  </a></li>
                <li class="divider"></li>
                <li><a href="#"><span class="fa fa-warning pull-right"></span>Report this user for spam</a></li>
                <li class="divider"></li>
                <li><a href="#" class="btn disabled" role="button"> Unfollow </a></li>
            </ul>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

    <!-- There are many built in button colors and sizes. If a link is to trigger in page functionality it should use role="button". The button element should be used in most situations -->
    <p>
        <a href="#" class="btn btn-default btn-lg" role="button">More info</a>
        <button type="submit" class="btn btn-danger" role="button">Button</button>
        <input type="button" value="Info" class="btn btn-info">
        <button type="submit" class="btn-primary btn-sm">Primary</button>
        <button type="submit" class="btn btn-success btn-xs">Success</button>
        <button type="submit" class="btn btn-warning btn-lg">Warning</button>
        <button type="submit" class="btn btn-link btn-lg">Link</button>

        <!-- You can disable buttons with disabled -->
        <button type="button" class="btn btn-lg btn-primary" disabled="disabled">Primary</button>

        <!-- You disable links in a similar way -->
        <a href="#" class="btn btn-default btn-lg disabled" role="button">Link</a>

        <!-- You can group buttons. You can size the buttons with btn-group-lg, btn-group-sm, or btn-group-xs -->
        <div class="btn-group btn-group-lg" role="group" aria-label="...">
            <button type="button" class="btn btn-default">Small</button>
            <button type="button" class="btn btn-default">Medium</button>
            <button type="button" class="btn btn-default">Large</button>
        </div>

    </p>
    <!-- bootstraptut2.html -->
    <!-- ICONS -->
    <!-- Bootstrap has hundreds of free icons. http://getbootstrap.com/components/#glyphicons They can be used on their own or inside of buttons with a link or regular button for example. -->
    <p>
        <span class="glyphicon glyphicon-film"></span>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.7/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>

