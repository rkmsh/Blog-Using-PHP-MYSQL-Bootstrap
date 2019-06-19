<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>

<?php
if(isset($_GET["id"])){
  $IdFromURL = $_GET["id"];
  $Connection;
  $Query = "UPDATE comments SET status='OFF' WHERE id='$IdFromURL'";
  $Execute = mysqli_query($Connection, $Query);
  if($Execute){
  $_SESSION["SuccessMessage"] = "Comment Dis-Approvedd Successfully";
  Redirect_to("Comments.php");
}else{
  $_SESSION["ErrorMessage"] = "Something Went Wrong. Try Again!";
  Redirect_to("Comments.php");
}
}
 ?>
