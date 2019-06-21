<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>

<?php
  if(isset($_POST["Submit"])){
    $Username = mysqli_real_escape_string($Connection, $_POST["Username"]);
    $Password = mysqli_real_escape_string($Connection, $_POST["Password"]);
    $ConfirmPassword = mysqli_real_escape_string($Connection, $_POST["ConfirmPassword"]);
    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime = Time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    $DateTime;
    $Admin = "Rohit Mahato";
    if(empty($Username) || empty($Password) || empty($ConfirmPassword)){
      $_SESSION["ErrorMessage"] = "All fields must be filled out";
      Redirect_to("Admins.php");
    }elseif (strlen($Password) < 4){
      $_SESSION["ErrorMessage"] = "Atleast 4 characters for Password are required.";
      Redirect_to("Admins.php");
    }elseif ($Password !== $ConfirmPassword){
      $_SESSION["ErrorMessage"] = "Password / Confirm Password does not match.";
      Redirect_to("Admins.php");
    }else {
      global $Connection;
      $Query = "INSERT INTO registration(datetime,username,password,addedby)
      VALUES('$DateTime','$Username','$Password','$Admin')";
      $Execute = mysqli_query($Connection,$Query);
      if ($Execute){
        $_SESSION["SuccessMessage"] = "Admin Added Successfully.";
        Redirect_to("Admins.php");
      }else {
        $_SESSION["ErrorMessage"] = "Admin failed to Add.";
        Redirect_to("Admins.php");
      }
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manage Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/adminstyles.css">
    <style>
      .FieldInfo{
        color: rgb(251, 174, 44);
        font-family: Bitter, Georgia, "Time New Roman", Times, serif;
        font-size: 1.2em;
      }
    </style>
</head>
<body>
  <div style="height: 10px; background: #27aae1;"></div>
  <nav class="navbar navbar-inverse" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
        data-target="#collapse">
        <span class="sr-only">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        <a class="navbar-brand" href="Blog.php">
          <img style="margin-top: -12px"src="images/favicon.png" alt="site-image" width="46";height="46";>
        </a>
      </div>
      <div class="collapse navbar-collapse" id="collapse">
      <ul class="nav navbar-nav lead">
        <li><a href="#">Home</a></li>
        <li class="active"><a href="Blog.php">Blog</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contact Us</a></li>
        <li><a href="#">Features</a></li>
      </ul>
      <form action="Blog.php" class="navbar-form navbar-right">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" name="Search">
        </div>
        <button class="btn btn-default" name="SearchButton">Go</button>
      </form>
    </div>
    </div>
  </nav>
  <div class="Line" style="height: 10px; background: #27aae1;"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <ul id="Side_Menu" class="nav nav-pills nav-stacked">
                    <li><a href="Dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
                    <li><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Post</a></li>
                    <li><a href="Categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
                    <li class="active"><a href="Admins.php"><span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
                    <li><a href="Comments.php"><span class="glyphicon glyphicon-comment"></span>&nbsp;Comments</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
                </ul>
            </div><!--Ending of Side Area-->
            <div class="col-sm-10">
                <h1>Manage Admin Access</h1>
                <?php
                echo Message();
                echo SuccessMessage();
               ?>
                <div>
                  <form action="Admins.php" method="post">
                    <fieldset>
                      <div class="form-group">


                        <label for="Username"><span class="FieldInfo">UserName:</span></label>
                        <input class="form-control" type="text" name="Username" id="Username" placeholder="Username">
                      </div>
                      <div class="form-group">


                        <label for="Password"><span class="FieldInfo">Password:</span></label>
                        <input class="form-control" type="Password" name="Password" id="Password" placeholder="Password">
                      </div>
                      <div class="form-group">


                        <label for="ConfirmPassword"><span class="FieldInfo">Confirm Password:</span></label>
                        <input class="form-control" type="Password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Retype Same Password">
                      </div>
                      <br>
                      <input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Admin">
                      <br>
                    </form>
                    </fieldset>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover">
                    <tr>
                      <th>Sr No.</th>
                      <th>Date & Time</th>
                      <th>Admin Name</th>
                      <th>Added By</th>
                      <th>Action</th>
                    </tr>
                    <?php
                    global $Connection;
                    $ViewQuery = "SELECT * FROM registration ORDER BY datetime desc";
                    $Execute = mysqli_query($Connection, $ViewQuery);
                    $SrNo = 0;
                    while($DataRows = mysqli_fetch_array($Execute)){
                      $Id = $DataRows["id"];
                      $DateTime = $DataRows["datetime"];
                      $Username = $DataRows["username"];
                      $Admin = $DataRows["addedby"];
                      $SrNo++;
                     ?>
                     <tr>
                       <td><?php echo $SrNo; ?></td>
                       <td><?php echo $DateTime; ?></td>
                       <td><?php echo $Username; ?></td>
                       <td><?php echo $Admin; ?></td>
                       <td><a href="DeleteAdmin.php?id=<?php echo $Id; ?>">
                         <span class="btn btn-danger">Delete</span>
                       </a></td>
                     </tr>
                   <?php } ?>
                  </table>
                </div>
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
