<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php Confirm_Login(); ?>

<?php
  if(isset($_POST["Submit"])){
    $Title = mysqli_real_escape_string($Connection, $_POST["Title"]);
    $Category = mysqli_real_escape_string($Connection, $_POST["Category"]);
    $Post = mysqli_real_escape_string($Connection, $_POST["Post"]);
    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime = Time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    $DateTime;
    $Admin = $_SESSION["Username"];
    $Image = $_FILES["Image"]["name"];
    $Target = "Upload/".basename($_FILES["Image"]["name"]);
    if(empty($Title)){
      $_SESSION["ErrorMessage"] = "Title can't be Empty.";
      Redirect_to("AddNewPost.php");
    }elseif (strlen($Title) < 2){
      $_SESSION["ErrorMessage"] = "Title must be at least two characters.";
      Redirect_to("AddNewPost.php");
    }else {
      global $Connection;
      $Query = "INSERT INTO admin_panel(datetime,title,category,author,image,post)
      VALUES('$DateTime', '$Title', '$Category', '$Admin', '$Image', '$Post')";
      $Execute = mysqli_query($Connection,$Query);
      move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
      if ($Execute){
        $_SESSION["SuccessMessage"] = "Post Added Successfully.";
        Redirect_to("AddNewPost.php");
      }else {
        $_SESSION["ErrorMessage"] = "Something went wrong. Try Again!!";
        Redirect_to("AddNewPost.php");
      }
    }
  }
?>
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
        <li><a href="Blog.php" target="_blank">Blog</a></li>
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
              <br><br>
                <ul id="Side_Menu" class="nav nav-pills nav-stacked">
                    <li><a href="Dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
                    <li class="active"><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Post</a></li>
                    <li><a href="Categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
                    <li><a href="Admins.php"><span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
                    <li><a href="Comments.php"><span class="glyphicon glyphicon-comment"></span>&nbsp;Comments</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
                </ul>
            </div><!--Ending of Side Area-->
            <div class="col-sm-10">
                <h1>Add New Post</h1>
                <?php
                echo Message();
                echo SuccessMessage();
               ?>
                <div>
                  <form action="AddNewPost.php" method="post" enctype="multipart/form-data">
                    <fieldset>
                      <div class="form-group">
                        <label for="title"><span class="FieldInfo">Title:</span></label>
                        <input class="form-control" type="text" name="Title" id="title" placeholder="Title">
                      </div>
                      <div class="form-group">
                        <label for="categoryselect"><span class="FieldInfo">Category:</span></label>
                        <select class="form-control" id="categoryselect" name="Category">
                          <?php
                          global $Connection;
                          $ViewQuery = "SELECT * FROM category ORDER BY datetime desc";
                          $Execute = mysqli_query($Connection, $ViewQuery);
                          while($DataRows = mysqli_fetch_array($Execute)){
                            $ID = $DataRows["id"];
                            $CategoryName = $DataRows["name"];

                           ?>
                           <option><?php echo $CategoryName; ?></option>
                         <?php } ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
                        <input type="File" class="form-control" name="Image" id="imageselect">
                      </div>
                      <div class="form-group">
                        <label for="postarea"><span class="FieldInfo">Post:</span></label>
                        <textarea class="form-control" name="Post" id="postarea"></textarea>
                      </div>
                      <br>
                      <input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Post">
                      <br>
                    </form>
                    </fieldset>
                </div>



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
