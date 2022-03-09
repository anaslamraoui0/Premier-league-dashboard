<?php SESSION_START();
   if(isset($_SESSION['profile_id'])){
    include('connect.php');
    if(isset($_GET['team'])){
      $team=$_GET['team'];
    }
    else{$team=$_SESSION['team_id'];}
    $sql='SELECT t.*, COUNT(p.Player_ID) AS number_players FROM `teams` AS t INNER JOIN player AS p ON t.Team_ID=p.Team_ID WHERE t.Team_ID='.$team.' GROUP BY t.Team_ID;';
    $sql2="SELECT date_t,hteam,hiteam,hscore,ateam,aiteam,ascore FROM result_table WHERE hteam_id=".$team." OR ateam_id=".$team." LIMIT 8;";
    $sql3="SELECT SUM(CASE WHEN Event_ID=1 THEN `Event_Value` END) AS goals,SUM(CASE WHEN Event_ID=2 THEN `Event_Value` END) AS Attempts,SUM(CASE WHEN Event_ID=3 THEN `Event_Value` END) AS Attempts_target,SUM(CASE WHEN Event_ID=4 THEN `Event_Value` END) AS s_passes,SUM(CASE WHEN Event_ID=5 THEN `Event_Value` END) AS f_passes FROM match_performance GROUP BY Team_ID HAVING Team_ID=".$team.";";
    $sql4="SELECT `winner`, 3*COUNT(`winner`) AS points FROM `result_table` GROUP BY winner HAVING NOT `winner`=0 ORDER BY points DESC;";
    $sql5="SELECT * FROM (SELECT p.First_name, p.Surname, SUM(CASE WHEN e.Event_ID=1 THEN e.Event_Value END) AS goals FROM match_performance AS e INNER JOIN player AS p ON e.Player_ID=p.Player_ID WHERE e.Team_ID=".$team." GROUP BY e.Player_ID ORDER BY goals DESC) AS t WHERE goals IS NOT NULL;";
    $position=mysqli_query($db,$sql4);
    $scorer=mysqli_query($db,$sql5);
    $mteam=mysqli_query($db,$sql);
    $myteam=mysqli_fetch_array($mteam);
    $attempt=mysqli_query($db,$sql3);
    $attempts=mysqli_fetch_array($attempt);
    $lastscore=mysqli_query($db,$sql2);
    $i=1;
    while($rowp=$position->fetch_assoc()){
      if($rowp['winner']=$team){
        $pos=$i;
        $point=$rowp['points'];
      }
      $i++;
    }

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>My Team - That's Goal</title>
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
        <a class="nav-link collapsed" href="match.php">
          <i class="bx bx-football"></i>
          <span>Results</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link" href="team.php">
          <i class="bx bx-coin"></i>
          <span>My Team</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="players.php">
          <i class="bi bi-people-fill"></i>
          <span>Players</span>
        </a>
      </li><!-- End Contact Page Nav -->
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>My Team</h1>
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
                        echo "<tr><th scope='row'>".$row["date_t"]."</th>";
                        echo "<td><a href='#' class='text-primary fw-bold'><img src='assets/img/".$row["hiteam"]."-logo-vector.png' class='mr-1 ranking'/> ".$row["hteam"]."</a></td>";
                        echo "<td>".$row["hscore"]."</td>";
                        echo "<td>".$row["ascore"]."</td>";
                        echo "<td><a href='#' class='text-primary fw-bold'><img src='assets/img/".$row["aiteam"]."-logo-vector.png' class='mr-1 ranking'/> ".$row["ateam"]."</a></td></tr>";
                      } ?>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Top Selling -->
            <!-- Ranking -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="card-body pb-0">
                  <h5 class="card-title">Attempts <span>| 2019-2020</span></h5>

                  <!-- Bar Chart -->
              <div id="barChartstats"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new ApexCharts(document.querySelector("#barChartstats"), {
                    series: [{
                      data: [<?php echo $attempts['goals'].", ".$attempts['Attempts'].", ".$attempts['Attempts_target']; ?>]
                    }],
                    chart: {
                      type: 'bar',
                      height: 350
                    },
                    fill:{
                      colors:['#e90052']
                    },
                    plotOptions: {
                      bar: {
                        borderRadius: 4,
                        horizontal: true,
                      }
                    },
                    dataLabels: {
                      enabled: false
                    },
                    xaxis: {
                      categories: ['Goals', 'Attempts', 'Attempts on Target'
                      ],
                    }
                  }).render();
                });
              </script>
              <!-- End Bar Chart -->

                </div>

              </div>
            </div><!-- End Ranking -->
            <!-- Ranking -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="card-body pb-0">
                  <h5 class="card-title">Passes <span>| 2019-2020</span></h5>

                  <!-- Donut Chart -->
              <div id="donutChart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new ApexCharts(document.querySelector("#donutChart"), {
                    series: [<?php echo $attempts['s_passes'].", ".$attempts['f_passes']; ?>],
                    chart: {
                      height: 350,
                      type: 'donut',
                      toolbar: {
                        show: true
                      }
                    },
                    labels: ['Successful Passes', 'Failed Passes'],
                  }).render();
                });
              </script>
              <!-- End Donut Chart -->

                </div>

              </div>
            </div><!-- End Ranking -->
          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">
          <!-- Card with an image on top -->
          <div class="card text-white bg-info mb-3">
            <div class="card-header bg-info  text-dark" style="border-bottom-color:#2980B9 ;">Ranking</div>
            <div class="card-body d-flex justify-content-between my-3">
              <?php echo "<img src='assets/img/".$myteam['image']."-logo-vector.png' alt='Profile' class='rounded-circle rank-profile'>"; ?>
              <h5 class="card-title mt-3"><?php echo "<i class='ri-number-".$pos." text-dark fw-bold'></i>"; ?></h5>
              <h5 class="card-title mt-3 text-dark"><?php echo $point; ?> points</h5>
            </div>
          </div><!-- End Card with an image on top -->
          <!-- Ranking -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto">

              <div class="card-body pb-0">
                <h5 class="card-title">Top scorer <span>| 2019-2020</span></h5>

                <!-- Bar Chart -->
            <div id="barChartgoal"></div>
            <?php 
            $players=array();
            $goals=array();
            while($rows=$scorer->fetch_assoc()){
              $goals[]=$rows['goals'];
              $players[]=$rows['First_name']." ".$rows['Surname'];
              }?>
            <script>
              document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#barChartgoal"), {
                  series: [{
                    data: [<?php foreach($goals as $g){echo $g.",";} ?>]
                  }],
                  chart: {
                    type: 'bar',
                    height: 200
                  },
                  fill:{
                    colors:['#38003c']
                  },
                  plotOptions: {
                    bar: {
                      borderRadius: 4,
                      horizontal: true,
                    }
                  },
                  dataLabels: {
                    enabled: false
                  },
                  xaxis: {
                    categories: [<?php foreach($players as $p){echo "'".$p."',";} ?>],
                  }
                }).render();
              });
            </script>
            <!-- End Bar Chart -->

              </div>

            </div>
          </div><!-- End Ranking -->
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
     header('location:pages-login.html');
   }
   ?>