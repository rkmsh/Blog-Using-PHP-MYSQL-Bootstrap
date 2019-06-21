<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>

<?php
  function Redirect_to($New_Location){
    header("Location:".$New_Location);
    exit;
  }

  function Login_Attempt($Username, $Password){
    global $Connection;
    $Query = "SELECT * FROM registration WHERE username = '$Username' AND password = '$Password'";
    $Execute = mysqli_query($Connection, $Query);
    if($admin = mysqli_fetch_assoc($Execute)){
      return $admin;
    }else{
      return null;
    }
  }
?>
