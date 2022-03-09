<?php SESSION_START();
   if(isset($_SESSION['profile_id'])){
    include('connect.php');
    $sql1="SELECT MONTH(m.Date) AS mon, p.First_name,p.Surname, t.team_name, SUM(e.Event_Value) AS Score, SUM(CASE WHEN e.Event_ID=1 THEN e.Event_Value END) AS Goal_Scored,SUM(CASE WHEN e.Event_ID=2 THEN e.Event_Value END) AS Attempts,SUM(CASE WHEN e.Event_ID=4 THEN e.Event_Value END) AS Successful_Passes FROM match_performance AS e INNER JOIN player as p on p.Player_ID=e.Player_ID INNER JOIN teams as t ON p.Team_ID=t.Team_ID INNER JOIN `match` AS m ON m.Match_ID=e.Match_ID GROUP BY MONTH(m.Date) ORDER BY m.Date DESC,SUM(e.Event_Value) DESC LIMIT 1;";
    $pom=mysqli_query($db,$sql1);
    $sql2="SELECT Match_ID,date_t,hteam,hiteam,hscore,ateam,aiteam,ascore FROM result_table LIMIT 12;";
    $lastscore=mysqli_query($db,$sql2);
    $sql3="SELECT e.Team_ID, t.team_name, t.image, w.points, SUM(CASE WHEN Event_ID=1 THEN Event_Value END) as goals, COUNT( DISTINCT e.Match_ID) AS game_played
    FROM match_performance AS e
    INNER JOIN teams as t ON e.Team_ID=t.Team_ID
    JOIN (SELECT winner, 3*COUNT(winner) AS points FROM result_table GROUP BY winner HAVING NOT winner=0) AS w WHERE e.Team_ID=w.winner
    GROUP BY e.Team_ID
    ORDER BY w.points DESC;";
    $table=mysqli_query($db,$sql3);
     ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - That's Goal</title>
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
        <a class="nav-link " href="index.php">
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
        <a class="nav-link collapsed" href="players.php">
          <i class="bi bi-people-fill"></i>
          <span>Players</span>
        </a>
      </li><!-- End Contact Page Nav -->
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Summary</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
            <!-- Ranking -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <img src="assets/img/premier-league.jpg" class="card-img-top" alt="...">

                <div class="card-body pb-0">
                  <h5 class="card-title">Standing <span>| 2019-2020</span></h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Ranking</th>
                        <th scope="col">Team</th>
                        <th scope="col">Points</th>
                        <th scope="col">Goals Scored</th>
                        <th scope="col">Game Played</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i=1;
                      while($row3=$table->fetch_assoc()){
                        echo "<tr>
                        <th scope='row'><i class='ri-number-".$i." text-dark fw-bold'></i></th>
                        <td><form action='team.php' method='get' id='".$row3['Team_ID']."'><input type='hidden' name='team' value=".$row3['Team_ID'].">
                        <button type='submit' class='btn btn-light border-0 bg-transparent'><img src='assets/img/".$row3['image']."-logo-vector.png' class='mr-1 ranking'/> ".$row3['team_name']."</button></td>
                        <td class='fw-bold'>".$row3['points']."</td>
                        <td>".$row3['goals']."</td>
                        <td>".$row3['game_played']."</td></form>
                      </tr>";
                      $i++;
                      }
                      ?>
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
                        echo "<p class='card-text'>Player of the month ".$row1["mon"]."</p>";
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
            </div>
          </div><!-- End Card with an image on top -->

          <!-- News & Updates Traffic -->
          <div class="card">

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
   else{
     header('location:pages-login.html');   }
?>