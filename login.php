<?php
include("connect.php");
    $matricule=$_POST['username'];
    $mdp=$_POST['password'];
    $reqlog="SELECT * FROM profiles WHERE username='{$matricule}' AND password='{$mdp}'";
    $sql="SELECT Match_ID FROM result_table LIMIT 1";
    $lastg=mysqli_query($db,$sql);
    $result=mysqli_query($db,$reqlog);
    $lastgame=mysqli_fetch_array($lastg);
    $compte=mysqli_fetch_array($result);
    if ($compte){
        SESSION_START();
        $_SESSION['username']=$compte['username'];
        $_SESSION['name']=$compte['name'];
        $_SESSION['email']=$compte['email'];
        $_SESSION['team_id']=$compte['Team_ID'];
        $_SESSION['password']=$compte['password'];
        $_SESSION['profile_id']=$compte['profile_id'];
        $_SESSION['function']=$compte['function'];
        $_SESSION['lastgame_id']=$lastgame['Match_ID'];
        header("location: ./index.php");
    }
    else{
        header("location: ./pages-error-404.html");
    }
?>