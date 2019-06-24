<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Blog Page</title>
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/publicstyles.css">
    <style>
    .col-sm-3{
      /*background-color: green;*/
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
            global $Connection;
            if(isset($_GET["SearchButton"])){
              $Search = $_GET["Search"];
              //Query When Search Button is active.
              $ViewQuery = "SELECT * FROM admin_panel WHERE datetime LIKE '%$Search%'
               OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR post LIKE '%$Search%'";
             }elseif(isset($_GET["Category"])){
               $Category = $_GET["Category"];
               $ViewQuery = "SELECT * FROM admin_panel WHERE category = '$Category' ORDER BY datetime desc";
               
             }elseif(isset($_GET["Page"])){
               //Query When Pagination is Active i.e Blog.php?Page=1
               $Page = $_GET["Page"];
               $ShowPostFrom = ($Page*5) - 5;
               if($Page == 0 || $Page < 1){
                 $ShowPostFrom = 0;
               }else{}
               $ViewQuery = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT $ShowPostFrom,5";
             }
            else{
              //The default Query for Blog.php Page
            $ViewQuery = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,5";}
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
                  if(strlen($Post)>150){
                    $Post = substr($Post,0,150)."...";
                  }
                  echo $Post;
               ?>
             </p>
             </div>
             <a href="FullPost.php?id=<?php echo $PostId; ?>"><span class="btn btn-info">
               Read More &rsaquo;&rsaquo;</span></a>
           </div>
         <?php } ?>
         <nav>
           <ul class="pagination pull-left pagination-lg">
             <?php
             if(isset($Page))
             {
                if($Page > 1){
                  ?>
                  <li><a href="Blog.php?Page=<?php echo $Page - 1; ?>">&laquo;</a></li>
              <?php }
            }?>
         <?php
         global $Connection;
         $QueryPagination = "SELECT COUNT(*) FROM admin_panel";
         $ExecutePagination = mysqli_query($Connection, $QueryPagination);
         $RowPagination = mysqli_fetch_array($ExecutePagination);
         $TotalPosts = array_shift($RowPagination);
         //echo $TotalPosts;
         $PostPagination = $TotalPosts / 5;
         $PostPagination = ceil($PostPagination);
         //echo $PostPerPage;
         for ($i=1;$i<=$PostPagination; $i++){
             if(isset($Page)){
             if($i == $Page){
            ?>

            <li class="active"><a href="Blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php
          }else{ ?>
            <li><a href="Blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php
          }
        }
      }?>
            <?php
            if(isset($Page))
            {
               if($Page + 1 <= $PostPagination){
                 ?>
                 <li><a href="Blog.php?Page=<?php echo $Page + 1; ?>">&raquo;</a></li>
             <?php }
           }?>
            </ul>
          </nav>
        </div><!--Ending Blog Main Area-->
        <div class="col-sm-offset-1 col-sm-3"><!--Side Area-->
          <h2>About Me</h2>
          <img class="img-responsive img-circle imageicon" src="images/Bunny.jpg">
          <p>This is testing paragraph. Any Error my occur as the user is going
            to test it violently.This is testing paragraph. Any Error my occur as the user is going
            to test it violently.This is testing paragraph. Any Error my occur as the user is going
            to test it violently.This is testing paragraph. Any Error my occur as the user is going
            to test it violently.This is testing paragraph. Any Error my occur as the user is going
            to test it violently.
          </p>
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h2 class="panel-title">Categories</h2>
            </div>
            <div class="panel-body">
              <?php
                global $Connection;
                $ViewQuery = "SELECT * FROM category ORDER BY datetime desc";
                $Execute = mysqli_query($Connection, $ViewQuery);
                while ($DataRows = mysqli_fetch_array($Execute)) {
                  $Id = $DataRows['id'];
                  $Category = $DataRows['name'];

               ?>
               <a href="Blog.php?Category=<?php echo $Category; ?>">
                 <span id="heading"><?php echo $Category."<br>"; ?></span>
               </a>
             <?php } ?>
            </div>
            <div class="panel-footer">

            </div>
          </div>
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h2 class="panel-title">Recent Posts</h2>
            </div>
            <div class="panel-body">
              Dummy Content
            </div>
            <div class="panel-footer">

            </div>
          </div>
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
