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
    if(empty($Username) || empty($Username) || empty($ConfirmPassword)){
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
      body{
        background-color: #ffffff;
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
        <li><a href="#">Rohit Mahato</a></li>
      </ul>

    </div>
    </div>
  </nav>
  <div class="Line" style="height: 10px; background: #27aae1;"></div>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-offset-4 col-sm-10 col-sm-4">
              <?php
              echo Message();
              echo SuccessMessage();
             ?>
             <br><br><br><br>
                <h2>Welcome Back!</h2>

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

                      <br>
                      <input class="btn btn-info btn-block" type="Submit" name="Submit" value="Login">
                      <br>
                    </form>
                    </fieldset>
                </div>

            </div><!--Ending of Main Area-->
        </div><!--Ending of Row-->
    </div><!--Ending of container fluid-->
</body>
</html>
