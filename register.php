<?php
include('connect.php');
$sql="INSERT INTO `profiles` (`name`, `username`, `password`, `Team_ID`, `function`) VALUES ('".$_POST['name']."', '".$_POST['username']."', '".$_POST['password']."', '".$_POST['team']."', '".$_POST['function']."');";
if(mysqli_query($db,$sql)){
    header("location:./pages-login.html");
}
else{
    header("location:./pages-error-400.html");
}
?>