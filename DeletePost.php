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
    $Admin = "Rohit Mahato";
    $Image = $_FILES["Image"]["name"];
    $Target = "Upload/".basename($_FILES["Image"]["name"]);

      global $Connection;
      $DeleteFromURL = $_GET['Delete'];
      $Query = "DELETE FROM admin_panel WHERE id = '$DeleteFromURL'";
      $Execute = mysqli_query($Connection,$Query);
      move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
      if ($Execute){
        $_SESSION["SuccessMessage"] = "Post Deleted Successfully.";
        Redirect_to("Dashboard.php");
      }else {
        $_SESSION["ErrorMessage"] = "Something went wrong. Try Again!!";
        Redirect_to("Dashboard.php");
      }

  }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Delete Post</title>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
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
                <h1>Delete Post</h1>
                <?php
                echo Message();
                echo SuccessMessage();
               ?>
                <div>
                  <?php
                  $SearchQueryParameter = $_GET['Delete'];
                  $Connection;
                  $Query = "SELECT * FROM admin_panel WHERE id='$SearchQueryParameter'";
                  $ExecuteQuery = mysqli_query($Connection, $Query);
                  while($DataRows = mysqli_fetch_array($ExecuteQuery)){
                    $TitleToBeUpdated = $DataRows['title'];
                    $CategoryToBeUpdated = $DataRows['category'];
                    $ImageToBeUpdated = $DataRows['image'];
                    $PostToBeUpdated = $DataRows['post'];
                  }
                   ?>
                  <form action="DeletePost.php?Delete=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                    <fieldset>
                      <div class="form-group">
                        <label for="title"><span class="FieldInfo">Title:</span></label>
                        <input disabled value="<?php echo $TitleToBeUpdated; ?>"class="form-control" type="text" name="Title" id="title" placeholder="Title">
                      </div>
                      <div class="form-group">
                        <span class="FieldInfo">Existing Category:</span>
                        <?php echo $CategoryToBeUpdated; ?>
                        <br>
                        <label for="categoryselect"><span class="FieldInfo">Category:</span></label>
                        <select disabled class="form-control" id="categoryselect" name="Category">
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
                        <span class="FieldInfo">Existing Image:</span>
                        <img src="Upload/<?php echo $ImageToBeUpdated; ?>" width="200";height="40px";>
                        <br>
                        <label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
                        <input disabled type="File" class="form-control" name="Image" id="imageselect">
                      </div>
                      <div class="form-group">
                        <label for="postarea"><span class="FieldInfo">Post:</span></label>
                        <textarea disabled class="form-control" name="Post" id="postarea">
                          <?php echo $PostToBeUpdated; ?>
                        </textarea>
                      </div>
                      <br>
                      <input class="btn btn-danger btn-block" type="Submit" name="Submit" value="Delete Post">
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
