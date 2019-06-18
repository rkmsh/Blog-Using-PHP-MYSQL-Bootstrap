<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dash Board</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/adminstyles.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <h1>Rohit Mahato</h1>
                <ul id="Side_Menu" class="nav nav-pills nav-stacked">
                    <li class="active"><a href="Dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Post</a></li>
                    <li><a href="Categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-comment"></span>&nbsp;Comments</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
                </ul>
            </div><!--Ending of Side Area-->
            <div class="col-sm-10">
              <div>

             </div>
                <h1>Admin Dashboard</h1>
                <div>
                  <?php
                  echo Message();
                  echo SuccessMessage();
                  ?>
             </div>
                <h4>About</h4>
                <p>Help Me Out!!!. <em>Stranger Things</em> will take into screen in the next summer.</p>

                <h4>About</h4>
                <p>Help Me Out!!!. <em>Stranger Things</em> will take into screen in the next summer.</p>

                <h4>About</h4>
                <p>Help Me Out!!!. <em>Stranger Things</em> will take into screen in the next summer.</p>

                <h4>About</h4>
                <p>Help Me Out!!!. <em>Stranger Things</em> will take into screen in the next summer.</p>

                <h4>About</h4>
                <p>Help Me Out!!!. <em>Stranger Things</em> will take into screen in the next summer.</p>

                <h4>About</h4>
                <p>Help Me Out!!!. <em>Stranger Things</em> will take into screen in the next summer.</p>

                <h4>About</h4>
                <p>Help Me Out!!!. <em>Stranger Things</em> will take into screen in the next summer.</p>

                <h4>About</h4>
                <p>Help Me Out!!!. <em>Stranger Things</em> will take into screen in the next summer.</p>

                <h4>About</h4>
                <p>Help Me Out!!!. <em>Stranger Things</em> will take into screen in the next summer.</p>

                <h4>About</h4>
                <p>Help Me Out!!!. <em>Stranger Things</em> will take into screen in the next summer.</p>

                <h4>About</h4>
                <p>Help Me Out!!!. <em>Stranger Things</em> will take into screen in the next summer.</p>
            </div><!--Ending of Main Area-->
        </div><!--Ending of Row-->
    </div><!--Ending of container fluid-->

    <div id="Footer">
    <hr><p>Theme By | Rohit Mahato |&copy;2019-2024 --- All right reserved.
        </p>
        <a style="color: white; text-decoration: none; cursor: pointer; font-weight:bold;" href="http://rohitmahato.com/coupons/" target="_blank">
            <p>
                This site is only used for Study purpose rohitmahato.com have all the rights. no one is allow to distribute
                copies other then <br>&trade; rohitmahato.com &trade;  Udemy ; &trade; Skillshare ; &trade; StackSkills</p><hr>
        </a>

    </div>
    <div style="height: 10px; background: #27AAE1;"></div>
</body>
</html>
