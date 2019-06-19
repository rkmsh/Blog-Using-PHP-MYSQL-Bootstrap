<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>

<?php
  if(isset($_POST["Submit"])){
    $Name = mysqli_real_escape_string($Connection, $_POST["Name"]);
    $Email = mysqli_real_escape_string($Connection, $_POST["Email"]);
    $Comment = mysqli_real_escape_string($Connection, $_POST["Comment"]);
    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime = Time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    $DateTime;
    $PostId = $_GET["id"];
    if(empty($Name) || empty($Email) || empty($Comment)){
      $_SESSION["ErrorMessage"] = "All Fiels are required.";
    }elseif (strlen($Comment) > 500){
      $_SESSION["ErrorMessage"] = "Only 500 hundred characters are allowed.";
    }else {
      $PostIDFromURL = $_GET["id"];
      global $Connection;
      $Query = "INSERT INTO comments(datetime, name, email, comment, status, admin_panel_id)
      VALUES('$DateTime','$Name','$Email','$Comment','OFF', '$PostIDFromURL')";
      $Execute = mysqli_query($Connection,$Query);
      if ($Execute){
        $_SESSION["SuccessMessage"] = "Comment Submitted Successfully.";
        Redirect_to("FullPost.php?id={$PostId}");
      }else {
        $_SESSION["ErrorMessage"] = "Something went wrong. Try Again!!";
        Redirect_to("FullPost.php?id={$PostId}");
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Full Blog Post</title>
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/publicstyles.css">
    <style>
    .col-sm-3{
      background-color: green;
    }
    .FieldInfo{
      color: rgb(251, 174, 44);
      font-family: Bitter, Georgia, "Times New Roman", Times, serif;
      font-size: 1.2em;
    }
    .CommentBlock{
      background-color: #F6F7F9;
    }
    .Comment-info{
      color: #365899;
      font-family: sans-sans-serif;
      font-size: 1.1em;
      font-weight: bold;
      padding-top: 10px;
    }
    .Comment{
      margin-top: -2px;
      padding-bottom: 10px;
      font-size: 1.1em;
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
    <div class="container"><!--Container-->
      <div class="blog-header">
        <h1>The Complete Responsive CMS Blog</h1>
        <p class="lead">The Complete blog using PHP by Rohit Mahato</p>
      </div>
      <div class="row"><!--Row-->
        <div class="col-sm-8"><!--Main Blog Area-->
          <?php
          echo Message();
          echo SuccessMessage();
         ?>
          <?php
            global $Connection;
            if(isset($_GET["SearchButton"])){
              $Search = $_GET["Search"];
              $ViewQuery = "SELECT * FROM admin_panel WHERE datetime LIKE '%$Search%'
               OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR post LIKE '%$Search%'";
            }else{
                $PostIDFromURL = $_GET["id"];
                $ViewQuery = "SELECT * FROM admin_panel WHERE id='$PostIDFromURL' ORDER BY
                datetime desc";}
            $Execute = mysqli_query($Connection, $ViewQuery);
            while($DataRows=mysqli_fetch_array($Execute)){
              $PostId=$DataRows["id"];
              $DateTime=$DataRows["datetime"];
              $Title=$DataRows["title"];
              $Category=$DataRows["category"];
              $Admin=$DataRows["author"];
              $Image=$DataRows["image"];
              $Post=$DataRows["post"];

           ?>
           <div class="thumbnail">
             <img class="img-responsive img-rounded" src="Upload/<?php echo $Image; ?>">
             <div class="caption">
               <h1 id="heading"><?php echo htmlentities($Title); ?></h1>
               <p class="description">Category:<?php echo htmlentities($Category); ?> Published On
                 <?php echo htmlentities($DateTime); ?>
               </p>
               <p class="post">
                <?php
                  echo $Post;
               ?>
             </p>
           </div>
         </div>
         <?php } ?>
         <br><br>
         <br><br>
         <span class="FieldInfo">Comments:</span>
         <?php
         $Connection;
         $PostIdForComments = $_GET["id"];
         $ExtractingCommentsQuery = "SELECT * FROM comments WHERE admin_panel_id = '$PostIdForComments' AND status = 'ON'";
         $Execute = mysqli_query($Connection, $ExtractingCommentsQuery);
         while($DataRows = mysqli_fetch_array($Execute)){
           $CommentDate = $DataRows["datetime"];
           $CommenterName = $DataRows["name"];
           $Comments = $DataRows["comment"];

          ?>
          <div class="CommentBlock">
            <img style="margin-left: 10px; margin-top: 10px;" class="pull-left" src="images/comment.png" width="70px";height="70px";>
            <p style="margin-left: 90px;" class="Comment-info"><?php echo $CommenterName; ?></p>
            <p style="margin-left: 90px;" class="description"><?php echo $CommentDate; ?></p>
            <p style="margin-left: 90px;" class="Comment"><?php echo $Comments; ?></p>
          </div>
          <hr>
        <?php } ?>
         <br>
         <span class="FieldInfo">Share your thoughts about this post.</span>
         <br>
         <br>
         <div>
           <form action="FullPost.php?id=<?php echo $PostId; ?>" method="post" enctype="multipart/form-data">
             <fieldset>
               <div class="form-group">
                 <label for="Name"><span class="FieldInfo">Name:</span></label>
                 <input class="form-control" type="text" name="Name" id="Name" placeholder="Name">
               </div>
               <div class="form-group">
                 <label for="Email"><span class="FieldInfo">Email:</span></label>
                 <input class="form-control" type="email" name="Email" id="Email" placeholder="Email">
               </div>
               <div class="form-group">
                 <label for="commentarea"><span class="FieldInfo">Comment:</span></label>
                 <textarea class="form-control" name="Comment" id="commentarea"></textarea>
               </div>
               <input class="btn btn-primary" type="Submit" name="Submit" value="Submit">
               <br><br>
             </form>
             <br>
             </fieldset>
         </div>
        </div><!--Ending Blog Main Area-->
        <div class="col-sm-offset-1 col-sm-3"><!--Side Area-->
          <h2>Test</h2>
          <p>This is testing paragraph. Any Error my occur as the user is going
            to test it violently.This is testing paragraph. Any Error my occur as the user is going
            to test it violently.This is testing paragraph. Any Error my occur as the user is going
            to test it violently.This is testing paragraph. Any Error my occur as the user is going
            to test it violently.This is testing paragraph. Any Error my occur as the user is going
            to test it violently.
          </p>
        </div><!--Side Area Ending-->
      </div><!--Row Ending-->
    </div><!--Container Ending-->
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
