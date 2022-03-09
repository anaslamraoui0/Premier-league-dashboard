<?php SESSION_START();
   if(isset($_SESSION['profile_id'])){
    include('connect.php');
    $sql="SELECT l.*,p.Position FROM player AS l INNER JOIN position as p ON l.Player_ID=p.Players_ID WHERE l.Team_ID=".$_SESSION['team_id'].";";
    $res=mysqli_query($db,$sql);
    $sql2='SELECT t.*, COUNT(p.Player_ID) AS number_players FROM `teams` AS t INNER JOIN player AS p ON t.Team_ID=p.Team_ID WHERE t.Team_ID='.$_SESSION['team_id'].' GROUP BY t.Team_ID;';
    $mteam=mysqli_query($db,$sql2);
    $myteam=mysqli_fetch_array($mteam);
    $sql1="SELECT MONTH(m.Date) AS m, p.First_name,p.Surname, t.team_name, SUM(e.Event_Value) AS Score, SUM(CASE WHEN e.Event_ID=1 THEN e.Event_Value END) AS Goal_Scored,SUM(CASE WHEN e.Event_ID=2 THEN e.Event_Value END) AS Attempts,SUM(CASE WHEN e.Event_ID=4 THEN e.Event_Value END) AS Successful_Passes FROM match_performance AS e INNER JOIN player as p on p.Player_ID=e.Player_ID INNER JOIN teams as t ON p.Team_ID=t.Team_ID INNER JOIN `match` AS m ON m.Match_ID=e.Match_ID WHERE e.Team_ID=".$_SESSION['team_id']." GROUP BY MONTH(m.Date) ORDER BY m.Date DESC,SUM(e.Event_Value) DESC LIMIT 1";
    $pom=mysqli_query($db,$sql1);
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Players - That's Goal</title>
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
        <a class="nav-link collapsed" href="match.php">
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
        <a class="nav-link" href="players.php">
          <i class="bi bi-people-fill"></i>
          <span>Players</span>
        </a>
      </li><!-- End Contact Page Nav -->
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <div class="col-12">
          <div class="card mb-3">
            <div class="row g-0">
              <div class="col-md-4">
                <?php echo "<img src='assets/img/".$myteam['image']."-profile.png' class='img-fluid rounded-start' alt='...'>"; ?>
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $myteam['team_name']; ?></h5>
                  <p class="card-text">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"><i class="bx bxs-coin mr-2"></i>&nbsp;&nbsp; <?php echo $myteam['stadium']; ?></li>
                      <li class="list-group-item"><i class="bx bx-map-pin mr-2"></i>&nbsp;&nbsp; <?php echo $myteam['Adress']; ?></li>
                      <li class="list-group-item"><i class="bi bi-people-fill mr-2"></i>&nbsp;&nbsp; <?php echo $myteam['number_players']; ?> Players</li>
                    </ul>
                  </p>
                </div>
              </div>
            </div>
          </div><!-- End Card with an image on left -->
        </div>
        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
            <!-- Ranking -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <img src="assets/img/premier-league.jpg" class="card-img-top" alt="...">

                <div class="card-body pb-0">
                  <h5 class="card-title">List of Players <span>| 2019-2020</span></h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Player Name</th>
                        <th scope="col">Position</th>
                        <th scope="col">Height and Width</th>
                        <th scope="col">National Apperance</th>
                        <th scope="col">International Apperance</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    while($row=$res->fetch_assoc()){
                      echo '<tr><th scope="row">'.$row['First_name'].' '.$row['Surname'].'</th>';
                      echo '<td class="fw-bold">'.$row['Position'].'</td>';
                      echo '<td class="fw-bold">'.$row['Height'].' : '.$row['Weight'].'</td>';
                      echo '<td class="fw-bold">'.$row['National_matches'].'</td>';
                      echo '<td class="fw-bold">'.$row['International_matches'].'</td></tr>';
                    }
                      ?>
                      <!--<tr>
                        <th scope="row"><i class="ri-number-1 text-success fw-bold"></i></th>
                        <td><a href="#" class="text-primary fw-bold"><img src="assets/img/arsenal-logo-vector.png" class="mr-1 ranking"/> Arsenal</a></td>
                        <td class="fw-bold">24</td>
                        <td>30</td>
                        <td>5</td>
                      </tr>
                      <tr>
                        <th scope="row"><i class="ri-number-2 text-warning"></i></th>
                        <td><a href="#" class="text-primary fw-bold"><img src="assets/img/manchester-city-fc-logo-vector.png" class="mr-1 ranking"/> Manchester City</a></td>
                        <td class="fw-bold">22</td>
                        <td>25</td>
                        <td>5</td>
                      </tr>
                      <tr>
                        <th scope="row"><i class="ri-number-3 text-danger"></i></th>
                        <td><a href="#" class="text-primary fw-bold"><img src="assets/img/manchester-united-logo-vector.png" class="mr-1 ranking"/> Manchester United</a></td>
                        <td class="fw-bold">21</td>
                        <td>23</td>
                        <td>5</td>
                      </tr>
                      <tr>
                        <th scope="row"><i class="ri-number-4 text-dark"></i></th>
                        <td><a href="#" class="text-primary fw-bold"><img src="assets/img/chelsea-logo-vector.png" class="mr-1 ranking"/> Chelsea</a></td>
                        <td class="fw-bold">18</td>
                        <td>21</td>
                        <td>5</td>
                      </tr>
                      <tr>
                        <th scope="row"><i class="ri-number-5 text-dark"></i></th>
                        <td><a href="#" class="text-primary fw-bold"><img src="assets/img/liverpool-logo-vector.png" class="mr-1 ranking"/> Liverpool</a></td>
                        <td class="fw-bold">15</td>
                        <td>18</td>
                        <td>5</td>
                      </tr>-->
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Ranking -->
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
                      <tr>
                        <th scope="row">2020-10-13</th>
                        <td><a href="#" class="text-primary fw-bold"><img src="assets/img/arsenal-logo-vector.png" class="mr-1 ranking"/> Arsenal</a></td>
                        <td>2</td>
                        <td>3</td>
                        <td><a href="#" class="text-primary fw-bold"><img src="assets/img/manchester-city-fc-logo-vector.png" class="mr-1 ranking"/> Manchester City</a></td>
                      </tr>
                      <tr>
                        <th scope="row">2020-10-13</th>
                        <td><a href="#" class="text-primary fw-bold"><img src="assets/img/manchester-united-logo-vector.png" class="mr-1 ranking"/> Manchester United</a></td>
                        <td>2</td>
                        <td>2</td>
                        <td><a href="#" class="text-primary fw-bold"><img src="assets/img/chelsea-logo-vector.png" class="mr-1 ranking"/> Chelsea</a></td>
                      </tr>
                      <tr>
                        <th scope="row">2020-10-12</th>
                        <td><a href="#" class="text-primary fw-bold"><img src="assets/img/liverpool-logo-vector.png" class="mr-1 ranking"/> Liverpool</a></td>
                        <td>4</td>
                        <td>1</td>
                        <td><a href="#" class="text-primary fw-bold"><img src="assets/img/tottenham-hotspur-logo-vector.png" class="mr-1 ranking"/> Tottenham Hotspur</a></td>
                      </tr>
                      <tr>
                        <th scope="row">2020-10-11</th>
                        <td><a href="#" class="text-primary fw-bold"><img src="assets/img/everton-logo-vector.png" class="mr-1 ranking"/> Everton</a></td>
                        <td>2</td>
                        <td>3</td>
                        <td><a href="#" class="text-primary fw-bold"><img src="assets/img/leicester-city-logo-vector.png" class="mr-1 ranking"/> Leicester City</a></td>
                      </tr>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Top Selling -->
            <!-- Sales Card -->
            <div class="col-xxl-12 col-md-12">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Last Game <span>| 2/17/2022</span></h5>

                  <div class="d-flex align-items-center justify-content-between">
                    <div class="card-icon rounded-circle float-left align-items-center justify-content-center">
                      <img class="teams" src="assets/img/arsenal-logo-vector.png"/>
                    </div>
                    <div class="ps-3 float-left">
                      <h6>2</h6>
                      <!--<span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>-->

                    </div>
                    <div class="ps-3 float-right">
                      <h6>1</h6>
                      <!--<span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>-->

                    </div>
                    <div class="card-icon rounded-circle float-right align-items-center justify-content-center">
                      <img class="teams" src="assets/img/liverpool-logo-vector.png"/>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="text-dark medium">Arsenal</span>
                    <span class="text-primary small pt-1 fw-bold">Emirates Stadium - 21:00</span>
                    <span class="text-dark medium">Liverpool</span>
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
                        <div class="progress-bar" role="progressbar" style="width: 66.66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100">2</div>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                        <div class="progress-bar" role="progressbar" style="width: 33.33%" aria-valuemin="0" aria-valuemax="100">1</div>
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
                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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
                        <div class="progress-bar" role="progressbar" style="width: 66.66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                        <div class="progress-bar" role="progressbar" style="width: 33.33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
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
                        <div class="progress-bar" role="progressbar" style="width: 66.66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                        <div class="progress-bar" role="progressbar" style="width: 33.33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
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
                        <div class="progress-bar" role="progressbar" style="width: 66.66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                        <div class="progress-bar" role="progressbar" style="width: 33.33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
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
                        <div class="progress-bar" role="progressbar" style="width: 66.66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                        <div class="progress-bar" role="progressbar" style="width: 33.33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
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
                        <div class="progress-bar" role="progressbar" style="width: 66.66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                        <div class="progress-bar" role="progressbar" style="width: 33.33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
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
                        <div class="progress-bar" role="progressbar" style="width: 66.66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                        <div class="progress-bar" role="progressbar" style="width: 33.33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
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
                        <div class="progress-bar" role="progressbar" style="width: 66.66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-xxl-6 col-md-6 d-flex justify-content-between">
                      <div class="progress col-xxl col-md">
                        <div class="progress-bar" role="progressbar" style="width: 33.33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
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
          </div>
            <div class="row">

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Revenue <span>| This Month</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6>$3,264</h6>
                      <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Customers <span>| This Year</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>1244</h6>
                      <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Reports <span>/Today</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Sales',
                          data: [31, 40, 28, 51, 42, 82, 56],
                        }, {
                          name: 'Revenue',
                          data: [11, 32, 45, 32, 34, 52, 41]
                        }, {
                          name: 'Customers',
                          data: [15, 11, 32, 18, 9, 24, 11]
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'datetime',
                          categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy HH:mm'
                          },
                        }
                      }).render();
                    });
                  </script>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Reports -->


          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">
          <!-- Card with an image on top -->
          <div class="card">
            <img src="assets/img/playofthemonth.png" class="card-img-top" alt="...">
            <div class="card-body">
            <?php
                      while($row1=$pom->fetch_assoc()){
                        echo "<h5 class='card-title'>".$row1["First_name"]." ".$row1["Surname"]."</h5>";
                        echo "<h5 class='card-title'>".$row1["team_name"]."</h5>";
                        echo "<p class='card-text'>Player of the month ".$row1["m"]."</p>";
                        echo "<div id='radialBarChart'></div>";
                        echo "<script>
                        document.addEventListener('DOMContentLoaded', () => {
                          new ApexCharts(document.querySelector('#radialBarChart'), {
                            series: [".$row1["Successful_Passes"].", ".$row1["Attempts"].", ".$row1["Goal_Scored"]."],
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
                                      return ".$row1["Score"]."
                                    }
                                  }
                                }
                              }
                            },
                            labels: ['Successfull Passes', 'Attempts on Target', 'Goals'],
                          }).render();
                        });
                      </script>";
                      }
              ?>
              <!-- End Radial Bar Chart -->
            </div>
          </div><!-- End Card with an image on top -->
          <!-- Recent Activity -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Last game <span>| Highlights</span></h5>

              <div class="activity">

                <div class="activity-item d-flex">
                  <div class="activite-label">32 min</div>
                  <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                  <div class="activity-content">
                    Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">56 min</div>
                  <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                  <div class="activity-content">
                    Voluptatem blanditiis blanditiis eveniet
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">2 hrs</div>
                  <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                  <div class="activity-content">
                    Voluptates corrupti molestias voluptatem
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">1 day</div>
                  <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                  <div class="activity-content">
                    Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati voluptatem</a> tempore
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">2 days</div>
                  <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                  <div class="activity-content">
                    Est sit eum reiciendis exercitationem
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">4 weeks</div>
                  <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                  <div class="activity-content">
                    Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
                  </div>
                </div><!-- End activity item-->

              </div>

            </div>
          </div><!-- End Recent Activity -->

          <!-- Card with an image overlay -->
          <div class="card">
            <img src="assets/img/playofthemonth.png" class="card-img-top" alt="...">
            <div class="card-img-overlay">
              <h5 class="card-title">Alexander Lacazette</h5>
              <p class="card-text">Player of the month February</p>
            </div>
          </div><!-- End Card with an image overlay -->
          <!-- Card with an image on bottom -->

          <!-- Website Traffic -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>
          </div><!-- End Website Traffic -->

          <!-- News & Updates Traffic -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">News &amp; Updates <span>| Today</span></h5>

              <div class="news">
                <div class="post-item clearfix">
                  <img src="assets/img/news-1.jpg" alt="">
                  <h4><a href="#">Nihil blanditiis at in nihil autem</a></h4>
                  <p>Sit recusandae non aspernatur laboriosam. Quia enim eligendi sed ut harum...</p>
                </div>

                <div class="post-item clearfix">
                  <img src="assets/img/news-2.jpg" alt="">
                  <h4><a href="#">Quidem autem et impedit</a></h4>
                  <p>Illo nemo neque maiores vitae officiis cum eum turos elan dries werona nande...</p>
                </div>

                <div class="post-item clearfix">
                  <img src="assets/img/news-3.jpg" alt="">
                  <h4><a href="#">Id quia et et ut maxime similique occaecati ut</a></h4>
                  <p>Fugiat voluptas vero eaque accusantium eos. Consequuntur sed ipsam et totam...</p>
                </div>

                <div class="post-item clearfix">
                  <img src="assets/img/news-4.jpg" alt="">
                  <h4><a href="#">Laborum corporis quo dara net para</a></h4>
                  <p>Qui enim quia optio. Eligendi aut asperiores enim repellendusvel rerum cuder...</p>
                </div>

                <div class="post-item clearfix">
                  <img src="assets/img/news-5.jpg" alt="">
                  <h4><a href="#">Et dolores corrupti quae illo quod dolor</a></h4>
                  <p>Odit ut eveniet modi reiciendis. Atque cupiditate libero beatae dignissimos eius...</p>
                </div>

              </div><!-- End sidebar recent posts-->

            </div>
          </div><!-- End News & Updates -->

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
   else {
     header('location:pages-login.html');
   }
?>