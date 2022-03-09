<?php
    $db=mysqli_connect("localhost","root","","thatsgoal");
    if(!$db){
        header("location:./pages-error-400.html");
    }
?>