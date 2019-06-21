<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php Confirm_Login(); ?>

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
                    <li class="active"><a href="Dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
                    <li><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Post</a></li>
                    <li><a href="Categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
                    <li><a href="Admins.php"><span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
                    <li><a href="Comments.php"><span class="glyphicon glyphicon-comment"></span>&nbsp;Comments
                      <?php
                      $Connection;
                      $QueryTotal = "SELECT COUNT(*) FROM comments WHERE status = 'OFF'";
                      $ExecuteTotal = mysqli_query($Connection, $QueryTotal);
                      $RowsTotal = mysqli_fetch_array($ExecuteTotal);
                      $Total = array_shift($RowsTotal);
                      if($Total > 0){
                        ?>
                        <span class="label label-warning pull-right">
                        <?php echo $Total; ?>
                        </span>
                      <?php } ?>
                    </a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a></li>
                    <li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
                </ul>
            </div><!--Ending of Side Area-->
            <div class="col-sm-10"><!--Main Area-->
              <div>
                  <?php
                  echo Message();
                  echo SuccessMessage();
                  ?>
             </div>
                <h1>Admin Dashboard</h1>
                <div class="table-responsive">
                  <table class="table table-striped table-hover">
                    <tr>
                      <th>No</th>
                      <th>Post Title</th>
                      <th>Date & Time</th>
                      <th>Author</th>
                      <th>Category</th>
                      <th>Banner</th>
                      <th>Comments</th>
                      <th>Action</th>
                      <th>Details</th>
                    </tr>
                    <?php
                    $Connection;
                    $ViewQuery = "SELECT * FROM admin_panel ORDER BY datetime desc";
                    $Execute = mysqli_query($Connection, $ViewQuery);
                    $SrNo = 0;
                    while($DataRows = mysqli_fetch_array($Execute)){
                      $Id = $DataRows["id"];
                      $DateTime = $DataRows["datetime"];
                      $Title = $DataRows["title"];
                      $Category = $DataRows["category"];
                      $Admin = $DataRows["author"];
                      $Image = $DataRows["image"];
                      $Post = $DataRows["post"];
                      $SrNo++;
                      ?>
                      <tr>
                        <td><?php echo $SrNo ?></td>
                        <td style="color: #5e5eff;"><?php
                        if(strlen($Title)>20){$Title = substr($Title, 0, 20)."..";}
                        echo $Title ?>
                      </td>
                        <td><?php
                        if(strlen($DateTime)>11){$DateTime = substr($DateTime, 0, 11)."..";}
                        echo $DateTime ?>
                        </td>
                        <td><?php
                        if(strlen($Admin)>6){$Admin = substr($Admin, 0, 6)."..";}
                        echo $Admin ?>
                        </td>
                        <td><?php
                        if(strlen($Category)>7){$Category = substr($Category, 0, 7)."..";}
                        echo $Category ?></td>
                        <td><img src="Upload/<?php echo $Image ?>" width="200";height="40px"></td>
                        <td>
                          <?php
                          $Connection;
                          $QueryApproved = "SELECT COUNT(*) FROM comments WHERE admin_panel_id='$Id' AND status = 'ON'";
                          $ExecuteApproved = mysqli_query($Connection, $QueryApproved);
                          $RowsApproved = mysqli_fetch_array($ExecuteApproved);
                          $TotalApproved = array_shift($RowsApproved);
                          if($TotalApproved > 0){
                            ?>
                            <span class="label label-success pull-right">
                            <?php echo $TotalApproved; ?>
                            </span>
                          <?php } ?>

                          <?php
                          $Connection;
                          $QueryUnApproved = "SELECT COUNT(*) FROM comments WHERE admin_panel_id='$Id' AND status = 'OFF'";
                          $ExecuteUnApproved = mysqli_query($Connection, $QueryUnApproved);
                          $RowsUnApproved = mysqli_fetch_array($ExecuteUnApproved);
                          $TotalUnApproved = array_shift($RowsUnApproved);
                          if($TotalUnApproved > 0){
                            ?>
                            <span class="label label-danger pull-left">
                            <?php echo $TotalUnApproved; ?>
                            </span>
                          <?php } ?>
                        </td>
                        <td><a href="EditPost.php?Edit=<?php echo $Id; ?>">
                          <span class="btn btn-warning">Edit</span></a>
                        <a href="DeletePost.php?Delete=<?php echo $Id; ?>">
                          <span class="btn btn-danger">Delete</span></a></td>
                        <td>
                          <a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank">
                          <span class="btn btn-primary">Live Preview</span></a></td>
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
