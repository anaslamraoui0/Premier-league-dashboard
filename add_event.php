<?php
include('connect.php');
$sql="INSERT INTO `event` (`event_name`) VALUES ('".$_POST['even_name']."');";
if(mysqli_query($db,$sql)){
    header("location:./match.php");
}
else{
    header("location:./pages-error-400.html");

?>