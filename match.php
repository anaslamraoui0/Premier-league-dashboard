<?php SESSION_START();
   if(isset($_SESSION['profile_id'])){
    $db=mysqli_connect("localhost","root","","thatsgoal");
    if(isset($_GET['game_id'])){
      $match_id=$_GET['game_id'];
    }
    else{$match_id=$_SESSION["lastgame_id"];}
    $sql="SELECT r.date_t,r.hteam,r.hiteam,r.hscore,r.ateam,r.aiteam,r.ascore,t.stadium FROM `result_table` AS r JOIN teams AS t WHERE r.hteam_id=t.Team_ID AND r.Match_ID=".$match_id.";";
    $sql1="SELECT e.Event_ID,e.Event_name,x.Surname, p.`Event_timing` FROM `match_performance` AS p INNER JOIN event as e ON p.Event_ID=e.Event_ID INNER JOIN player as x ON p.Player_ID=x.Player_ID WHERE p.Match_ID=".$match_id." AND p.Event_ID IN (1,3,7,8) ORDER BY p.Event_timing;";
    $sql3="SELECT p.First_name,p.Surname, t.team_name, SUM(e.Event_Value) AS Score, SUM(CASE WHEN e.Event_ID=1 THEN e.Event_Value END) AS Goal_Scored,SUM(CASE WHEN e.Event_ID=2 THEN e.Event_Value END) AS Attempts,SUM(CASE WHEN e.Event_ID=4 THEN e.Event_Value END) AS Successful_Passes FROM match_performance AS e INNER JOIN player as p on p.Player_ID=e.Player_ID INNER JOIN teams as t ON p.Team_ID=t.Team_ID INNER JOIN `match` AS m ON m.Match_ID=e.Match_ID WHERE e.Match_ID=".$match_id." ORDER BY SUM(e.Event_Value) DESC LIMIT 1;";
    $sql2="SELECT Match_ID,date_t,hteam,hiteam,hscore,ateam,aiteam,ascore FROM result_table LIMIT 12;";
    $sql4 ="SELECT * FROM backup_view WHERE Match_ID=".$match_id.";";
    $lastscore=mysqli_query($db,$sql2);
    $high=mysqli_query($db,$sql1);
    $finalres=mysqli_query($db,$sql);
    $momatch=mysqli_query($db,$sql3);
    $stats=mysqli_query($db,$sql4);
    $statsres=mysqli_fetch_array($stats);
    $manofmach=mysqli_fetch_array($momatch);
    $finalresult=mysqli_fetch_array($finalres);
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Matches - That's Goal</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo.jfif" rel="icon">
  <link href="assets/img/logo.jfif" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.jfif" alt="">
        <span class="d-none d-lg-block">That's Goal</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['name'];?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <?php echo "<h6>".$_SESSION['name']."</h6>";?>
              <?php echo "<span>".$_SESSION['function']."</span>";?>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php">
          <i class="bi bi-grid"></i>
          <span>Summary</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link " href="match.php">
          <i class="bx bx-football"></i>
          <span>Results</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="team.php">
          <i class="bx bx-coin"></i>
          <span>My Team</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="player.php">
          <i class="bi bi-people-fill"></i>
          <span>Players</span>
        </a>
      </li><!-- End Contact Page Nav -->
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Results</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
            <!-- Sales Card -->
            <div class="col-xxl-12 col-md-12">
              <div class="card info-card sales-card">
                <img src="assets/img/pl-match.jpg" class="card-img-top" alt="...">
                <div class="card-body card-img-overlay">
                  <h5 class="card-title">Last Game Final Score<span class='text-white'> | <?php echo $finalresult['date_t']; ?></span></h5>

                  <div class="d-flex align-items-center justify-content-between mt-5 p-3">
                    <div class="card-icon rounded-circle float-left align-items-center justify-content-center">
                      <?php echo "<img class='teams' src='assets/img/".$finalresult['hiteam']."-logo-vector.png'/>"; ?>
                    </div>
                    <div class="ps-3 float-left">
                      <h6><?php echo $finalresult['hscore']; ?></h6>

                    </div>
                    <div class="ps-3 float-right">
                      <h6><?php echo $finalresult['ascore']; ?></h6>

                    </div>
                    <div class="card-icon rounded-circle float-right align-items-center justify-content-center">
                    <?php echo "<img class='teams' src='assets/img/".$finalresult['aiteam']."-logo-vector.png'/>"; ?>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="text-dark fs-4 fw-bold"><?php echo $finalresult['hteam']; ?></span>
                    <span class="text-dark medium pt-1 fw-bold"><?php echo $finalresult['stadium']; ?></span>
                    <span class="text-dark fs-4 fw-bold"><?php echo $finalresult['ateam']; ?></span>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->
          </div>
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-12 col-md-12">
              <div class="card info-card sales-card">

                <div class="card-body py-2">
                  <h5 class="card-title">Match details</span></h5>
                  <!--Goal row-->
                  <div class="row align-items-center my-2">
                    <div class="col-xxl-6 col-md-6 d-flex">
                      <div class="d-flex col-xxl col-md">
                        <i class="ri-football-fill text-success mx-2"></i>
                        <span class="text-dark medium fw-bold">Goals</span>
                      </div>
                      <div class="progress col-xxl col-md justify-content-end">
                        <?php echo "<div class='progress-bar' role='progressbar' style='width: ".round($statsres['hscore']*100/($statsres['hscore']+$statsres['ascore']),2)."%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>".$statsres['hscore']."</div>"; ?>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                      <?php echo "<div class='progress-bar' role='progressbar' style='width: ".round($statsres['ascore']*100/($statsres['hscore']+$statsres['ascore']),2)."%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>".$statsres['ascore']."</div>"; ?>
                      </div>
                      <div class="d-flex col-xxl col-md justify-content-end">
                        <span class="text-dark medium fw-bold">Goals</span>
                        <i class="ri-football-fill text-success mx-2"></i>
                      </div>
                    </div>
                  </div>
                  <!--End goal row-->
                  <!--Attempts row-->
                  <div class="row align-items-center my-2">
                    <div class="col-xxl-6 col-md-6 d-flex">
                      <div class="d-flex col-xxl col-md">
                        <i class="ri-focus-2-line text-warning mx-2"></i>
                        <span class="text-dark medium fw-bold">Attempts</span>
                      </div>
                      <div class="progress col-xxl col-md justify-content-end">
                      <?php echo "<div class='progress-bar' role='progressbar' style='width: ".round($statsres['hattemps']*100/($statsres['hattemps']+$statsres['aattemps']),2)."%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>".$statsres['hattemps']."</div>"; ?>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                      <?php echo "<div class='progress-bar' role='progressbar' style='width: ".round($statsres['aattemps']*100/($statsres['hattemps']+$statsres['aattemps']),2)."%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>".$statsres['aattemps']."</div>"; ?>
                      </div>
                      <div class="d-flex col-xxl col-md justify-content-end">
                        <span class="text-dark medium fw-bold">Attempts</span>
                        <i class="ri-focus-2-line text-warning mx-2"></i>
                      </div>
                    </div>
                  </div>
                  <!--End Attempts row-->
                  <!--On Target row-->
                  <div class="row align-items-center my-2">
                    <div class="col-xxl-6 col-md-6 d-flex">
                      <div class="d-flex col-xxl col-md">
                        <i class="ri-focus-2-line text-success mx-2"></i>
                        <span class="text-dark medium fw-bold">On Target</span>
                      </div>
                      <div class="progress col-xxl col-md justify-content-end">
                      <?php echo "<div class='progress-bar' role='progressbar' style='width: ".round($statsres['hontarget']*100/($statsres['hontarget']+$statsres['aontarget']),2)."%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>".$statsres['hontarget']."</div>"; ?>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                      <?php echo "<div class='progress-bar' role='progressbar' style='width: ".round($statsres['aontarget']*100/($statsres['hontarget']+$statsres['aontarget']),2)."%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>".$statsres['aontarget']."</div>"; ?>
                      </div>
                      <div class="d-flex col-xxl col-md justify-content-end">
                        <span class="text-dark medium fw-bold">On Target</span>
                        <i class="ri-focus-2-line text-success mx-2"></i>
                      </div>
                    </div>
                  </div>
                  <!--End On Targets row-->
                  <!--Yellow card row-->
                  <div class="row align-items-center my-2">
                    <div class="col-xxl-6 col-md-6 d-flex">
                      <div class="d-flex col-xxl col-md">
                        <i class="ri-footprint-fill text-success mx-2"></i>
                        <span class="text-dark medium fw-bold">Successful Passes</span>
                      </div>
                      <div class="progress col-xxl col-md justify-content-end">
                      <?php echo "<div class='progress-bar' role='progressbar' style='width: ".round($statsres['hspasses']*100/($statsres['hspasses']+$statsres['aspasses']),2)."%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>".$statsres['hspasses']."</div>"; ?>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                      <?php echo "<div class='progress-bar' role='progressbar' style='width: ".round($statsres['aspasses']*100/($statsres['hspasses']+$statsres['aspasses']),2)."%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>".$statsres['aspasses']."</div>"; ?>
                      </div>
                      <div class="d-flex col-xxl col-md justify-content-end">
                        <span class="text-dark medium fw-bold">Successful Passes</span>
                        <i class="ri-footprint-fill text-success mx-2"></i>
                      </div>
                    </div>
                  </div>
                  <!--End goal row-->
                  <!--Yellow card row-->
                  <div class="row align-items-center my-2">
                    <div class="col-xxl-6 col-md-6 d-flex">
                      <div class="d-flex col-xxl col-md">
                        <i class="ri-footprint-fill text-danger mx-2"></i>
                        <span class="text-dark medium fw-bold">Failed Passes</span>
                      </div>
                      <div class="progress col-xxl col-md justify-content-end">
                      <?php echo "<div class='progress-bar' role='progressbar' style='width: ".round($statsres['hfpasses']*100/($statsres['hfpasses']+$statsres['afpasses']),2)."%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>".$statsres['hfpasses']."</div>"; ?>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                      <?php echo "<div class='progress-bar' role='progressbar' style='width: ".round($statsres['afpasses']*100/($statsres['hfpasses']+$statsres['afpasses']),2)."%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>".$statsres['afpasses']."</div>"; ?>
                      </div>
                      <div class="d-flex col-xxl col-md justify-content-end">
                        <span class="text-dark medium fw-bold">Failed Passes</span>
                        <i class="ri-footprint-fill text-danger mx-2"></i>
                      </div>
                    </div>
                  </div>
                  <!--End goal row-->
                  <!--Yellow card row-->
                  <div class="row align-items-center my-2">
                    <div class="col-xxl-6 col-md-6 d-flex">
                      <div class="d-flex col-xxl col-md">
                        <i class="bi bi-file-fill text-warning mx-2"></i>
                        <span class="text-dark medium fw-bold">Yellow cards</span>
                      </div>
                      <div class="progress col-xxl col-md justify-content-end">
                      <?php echo "<div class='progress-bar' role='progressbar' style='width: ".round($statsres['hycard']*100/($statsres['hycard']+$statsres['aycard']),2)."%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>".$statsres['hycard']."</div>"; ?>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                      <?php echo "<div class='progress-bar' role='progressbar' style='width: ".round($statsres['aycard']*100/($statsres['hycard']+$statsres['aycard']),2)."%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>".$statsres['aycard']."</div>"; ?>
                      </div>
                      <div class="d-flex col-xxl col-md justify-content-end">
                        <span class="text-dark medium fw-bold">Yellow cards</span>
                        <i class="bi bi-file-fill text-warning mx-2"></i>
                      </div>
                    </div>
                  </div>
                  <!--End goal row-->
                  <!--Red card row-->
                  <div class="row align-items-center my-2">
                    <div class="col-xxl-6 col-md-6 d-flex">
                      <div class="d-flex col-xxl col-md">
                        <i class="bi bi-file-fill text-danger mx-2"></i>
                        <span class="text-dark medium fw-bold">Red cards</span>
                      </div>
                      <div class="progress col-xxl col-md justify-content-end">
                      <?php 
                     # $hr=(isset($statsres['hrcard']))?$statsres['hrcard']:0;
                     # $ar=(isset($statsres['arcard']))?$statsres['hrcard']:0;
                      echo "<div class='progress-bar' role='progressbar' style='width: 0%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>0</div>";
                ?>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                        <?php echo "<div class='progress-bar' role='progressbar' style='width: 0%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>0</div>"; ?>
                      </div>
                      <div class="d-flex col-xxl col-md justify-content-end">
                        <span class="text-dark medium fw-bold">Red cards</span>
                        <i class="bi bi-file-fill text-danger mx-2"></i>
                      </div>
                    </div>
                  </div>
                  <!--End goal row-->
                  <!--Yellow card row-->
                  <div class="row align-items-center my-2">
                    <div class="col-xxl-6 col-md-6 d-flex">
                      <div class="d-flex col-xxl col-md">
                        <i class="bi bi-octagon-fill text-danger mx-2"></i>
                        <span class="text-dark medium fw-bold">Tackles</span>
                      </div>
                      <div class="progress col-xxl col-md justify-content-end">
                      <?php echo "<div class='progress-bar' role='progressbar' style='width: ".round($statsres['htackles']*100/($statsres['htackles']+$statsres['atackles']),2)."%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>".$statsres['htackles']."</div>"; ?>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                        <?php echo "<div class='progress-bar' role='progressbar' style='width: ".round($statsres['atackles']*100/($statsres['htackles']+$statsres['atackles']),2)."%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>".$statsres['atackles']."</div>"; ?>
                      </div>
                      <div class="d-flex col-xxl col-md justify-content-end">
                        <span class="text-dark medium fw-bold">Tackles</span>
                        <i class="bi bi-octagon-fill text-danger mx-2"></i>
                      </div>
                    </div>
                  </div>
                  <!--End goal row-->
                  <!--Yellow card row-->
                  <div class="row align-items-center my-2">
                    <div class="col-xxl-6 col-md-6 d-flex">
                      <div class="d-flex col-xxl col-md">
                        <i class="bi bi-flag-fill text-dark mx-2"></i>
                        <span class="text-dark medium fw-bold">Fouls</span>
                      </div>
                      <div class="progress col-xxl col-md justify-content-end">
                      <?php echo "<div class='progress-bar' role='progressbar' style='width: ".round($statsres['htackles']*100/($statsres['htackles']+$statsres['atackles']),2)."%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>".$statsres['htackles']."</div>"; ?>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                      <?php echo "<div class='progress-bar' role='progressbar' style='width: ".round($statsres['atackles']*100/($statsres['htackles']+$statsres['atackles']),2)."%' aria-valuenow='66' aria-valuemin='0' aria-valuemax='100'>".$statsres['atackles']."</div>"; ?>
                      </div>
                      <div class="d-flex col-xxl col-md justify-content-end">
                        <span class="text-dark medium fw-bold">Fouls</span>
                        <i class="bi bi-flag-fill text-dark mx-2"></i>
                      </div>
                    </div>
                  </div>
                  <!--End goal row-->
                </div>

              </div>
            </div><!-- End Sales Card -->
             <!-- Latest Scores -->
             <div class="col-12">
              <div class="card overflow-auto">
                <div class="card-body pb-0">
                  <h5 class="card-title">Latest Score <span>| 2019-2020</span></h5>

                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Home</th>
                        <th scope="col"> </th>
                        <th scope="col"> </th>
                        <th scope="col">Away</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                      while($row=$lastscore->fetch_assoc()){
                        echo "<form action='match.php' method='get'><input type='hidden' name='game_id' value=".$row['Match_ID']."><tr><th scope='row'><button type='submit' class='btn btn-light border-0 bg-transparent'>".$row["date_t"]."</button></th>";
                        echo "<td><p class='text-primary fw-bold'><img src='assets/img/".$row["hiteam"]."-logo-vector.png' class='mr-1 ranking'/> ".$row["hteam"]."</p></td>";
                        echo "<td class='fw-bold'>".$row["hscore"]."</td>";
                        echo "<td class='fw-bold'>".$row["ascore"]."</td>";
                        echo "<td><p class='text-primary fw-bold'><img src='assets/img/".$row["aiteam"]."-logo-vector.png' class='mr-1 ranking'/> ".$row["ateam"]."</p></td></tr></form>";
                      }
                      ?>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Top Selling -->
            <div class="col-12">
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Not Enough ? Add an Event</h5>
              <p>Personilize your analysis by adding an event</p>

              <!-- Vertical Form -->
              <form class="row g-3" action="add_event.php" method="post">
                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Name of the Event</label>
                  <input type="text" name="even_name" class="form-control" id="inputNanme4">
                </div>
                <div class="col-12">
                  <label for="inputEmail4" class="form-label">Description</label>
                  <input type="text" name="event_description" class="form-control" id="inputEmail4">
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form><!-- Vertical Form -->

            </div>
          </div>
            </div>
          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">
          <!-- Recent Activity -->
          <div class="card">

            <div class="card-body">
              <h5 class="card-title">Last game <span>| Highlights</span></h5>

              <div class="activity">

                  <?php
                  while($row=$high->fetch_assoc()){
                  echo "<div class='activity-item d-flex'><div class='activite-label'>".$row['Event_timing']."'</div>";
                  if($row['Event_ID']==1){echo "<i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>";}
                  elseif($row['Event_ID']==3){echo "<i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>";}
                  elseif($row['Event_ID']==7){echo "<i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>";}
                  else{echo "<i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>";}
                  echo "<div class='activity-content text-capitalize'>".$row['Event_name']." - ".$row['Surname']."
                </div>
              </div>";
                  
                  }
                  ?>

              </div>

            </div>
          </div><!-- End Recent Activity -->

          <!-- Card with an image on top -->
          <div class="card">
            <img src="assets/img/manofthematch.png" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"><?php echo $manofmach['First_name']." ".$manofmach['Surname']; ?></h5>
              <h5><?php echo $manofmach['team_name'];  ?></h5>
              <p class="card-text">Man of the match</p>
              <!-- Radial Bar Chart -->
              <div id="radialBarChart"></div>
              <?php
              echo "<script> 
                document.addEventListener('DOMContentLoaded', () => {
                  new ApexCharts(document.querySelector('#radialBarChart'), {
                    series: [".$manofmach['Successful_Passes'].", ".$manofmach['Attempts'].", ".$manofmach['Goal_Scored']."],
                    chart: {
                      height: 250,
                      type: 'radialBar',
                      toolbar: {
                        show: true
                      }
                    },
                    plotOptions: {
                      radialBar: {
                        dataLabels: {
                          name: {
                            fontSize: '22px',
                          },
                          value: {
                            fontSize: '16px',
                          },
                          total: {
                            show: true,
                            label: 'Total Points',
                            formatter: function(w) {
                              // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                              return ".$manofmach['Score']."
                            }
                          }
                        }
                      }
                    },
                    labels: ['Successfull Passes', 'Attempts on Target', 'Goals'],
                  }).render();
                });
              </script>";
              ?>
              <!-- End Radial Bar Chart -->
            </div>
          </div><!-- End Card with an image on top -->
          <!-- Card with an image on bottom -->

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Made with <i class="bi bi-heart-fill text-danger"></i> by <a href="#">Karla, Anass, Daniele and Islam</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
<?php
   }
   else{
     header('location: pages-login.html');
   }
?>